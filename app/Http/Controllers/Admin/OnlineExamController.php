<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Exams;
use App\Models\Exam_centers;
use App\Models\Exam_allocations;
use App\Models\Districts;
use App\Models\Questions;
use App\Models\Exam_attempts;
use App\Models\Exam_results;
use App\Models\Test_subjects;
use App\Helpers\Custom_helper;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Str;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;


class OnlineExamController extends Controller
{
    public function index(Request $request,$id)
    {

        return view('admin.online-exam.index',compact('id'));
    }
  
    public function validateCandidate(Request $request)
{
    // 1) Find allocation by the Exam ID provided by candidate
    $allocation = Exam_allocations::where('unique_id', $request->unique_id)->first();

    if (!$allocation) {
        return response()->json([
            'valid' => false,
            'is_accessible' => 0,
            'message' => 'Invalid Exam ID.',
        ]);
    }

    // 2) Resolve start/end (prefer DB; fallback to slot map if still empty)
    $tz  = config('app.timezone', 'UTC');
    $now = Carbon::now($tz);

    $start = $allocation->start_time ? Carbon::parse($allocation->start_time, $tz) : null;
    $end   = $allocation->end_time   ? Carbon::parse($allocation->end_time, $tz)   : null;

    if (!$start || !$end) {
        // Optional: fallback from `slot`
        $map = [
            'morning'   => ['10:00:00', '13:00:00'],
            'afternoon' => ['14:00:00', '17:00:00'],
            'evening'   => ['18:00:00', '21:00:00'],
        ];
        $slot = strtolower((string)$allocation->slot);
        if (!isset($map[$slot])) {
            return response()->json([
                'valid' => false,
                'is_accessible' => 0,
                'message' => 'Exam window is not configured. Please contact the invigilator.',
            ]);
        }
        $today = $now->copy()->startOfDay();
        $start = $today->copy()->setTimeFromTimeString($map[$slot][0]);
        $end   = $today->copy()->setTimeFromTimeString($map[$slot][1]);
    }

    // 3) Enforce the window
    if ($now->lt($start)) {
        return response()->json([
            'valid' => false,
            'is_accessible' => 0,
            'window' => [
                'start' => $start->toIso8601String(),
                'end'   => $end->toIso8601String(),
                'start_display' => $start->format('d M Y h:i A'),
                'end_display'   => $end->format('d M Y h:i A'),
            ],
            'message' => 'Exam will be accessible only after ' . $start->format('h:i A') . '.',
        ]);
    }

    if ($now->gte($end)) {
        return response()->json([
            'valid' => false,
            'is_accessible' => 0,
            'window' => [
                'start' => $start->toIso8601String(),
                'end'   => $end->toIso8601String(),
                'start_display' => $start->format('d M Y h:i A'),
                'end_display'   => $end->format('d M Y h:i A'),
            ],
            'message' => 'Exam is closed after ' . $end->format('h:i A') . '.',
        ]);
    }

    // 4) (Optional) Check if they already started once
    $attempt = Exam_attempts::where('unique_id', $request->unique_id)
        ->orderBy('id', 'asc')
        ->first();

    return response()->json([
        'valid' => true,
        'is_accessible' => 1,
        'already_attempted' => (bool) $attempt,
        'window' => [
            'start' => $start->toIso8601String(),
            'end'   => $end->toIso8601String(),
            'start_display' => $start->format('d M Y h:i A'),
            'end_display'   => $end->format('d M Y h:i A'),
        ],
        'message' => 'Access granted.',
    ]);
}

    public function fetchQuestions(Request $request)
    {
        $uniqueId = $request->unique_id;

        // Fetch all questions
        // $allQuestions = Questions::take(150)->get(['id','subject_id', 'title', 'opt_a', 'opt_b', 'opt_c', 'opt_d']);


        $totalQuestions = 150; // total questions you want
        $subjects = Test_subjects::withCount('questions')->get(); // get all subjects with question count

        $allQuestions = collect();

        foreach ($subjects as $subject) {
            $numQuestions = round($totalQuestions * ($subject->weightage_per / 100)); // proportional to weightage
            
            // Get random questions for this subject
            $questions = $subject->questions()
                                ->inRandomOrder()
                                ->take($numQuestions)
                                ->get(['id','subject_id','title','opt_a','opt_b','opt_c','opt_d']);

            $allQuestions = $allQuestions->merge($questions);
        }

        // Optionally shuffle all questions
        $allQuestions = $allQuestions->shuffle();




        // Fetch attempts for user
        $attempts = Exam_attempts::where('unique_id', $uniqueId)
            ->orderBy('id', 'asc') // preserve order of attempt
            ->get(['question_id', 'selected_option','time_remaining']);

        $attemptedIds = $attempts->pluck('question_id')->toArray();
        $selectedAnswers = $attempts->pluck('selected_option', 'question_id')->toArray();

        $attemptedQuestions = $allQuestions->whereIn('id', $attemptedIds)->values();
        $remainingQuestions = $allQuestions->whereNotIn('id', $attemptedIds)->shuffle()->values();

        if ($remainingQuestions->isEmpty()) {
            // No new questions left, show only attempted questions
            $finalQuestions = $attemptedQuestions;
        } else {
            // Show attempted first, then shuffled remaining
            $finalQuestions = $attemptedQuestions->concat($remainingQuestions);
        }

        $formatted = $finalQuestions->map(function ($q) {
            return [
                'id' => $q->id,
                'question' => $q->title,
                'options' => [
                    'A' => $q->opt_a,
                    'B' => $q->opt_b,
                    'C' => $q->opt_c,
                    'D' => $q->opt_d,
                ],
            ];
        });

        return response()->json([
            'questions' => $formatted,
            'selected_answers' => $selectedAnswers,
        ]);

    }

    public function fetchPreviousAttempts(Request $request)
    {
        return Exam_attempts::where('unique_id', $request->unique_id)
            ->orderBy('time_remaining', 'asc')
            ->get(['question_id', 'selected_option', 'time_remaining']);
    }

    public function saveEachAttempt(Request $request)
    {
        Exam_attempts::updateOrInsert(
            ['unique_id' => $request->unique_id, 'question_id' => $request->question_id],
            [
                'exam_id' => $request->exam_id,
                'selected_option' => $request->selected_option,
                'time_remaining' => $request->time_remaining,
                'time_taken' => $request->time_taken,
                'updated_at' => now()
            ]
        );

        return response()->json(['status' => 'saved']);
    }
    public function submitExam(Request $request)
    {
        if($request->unique_id){
            Exam_results::updateOrCreate(
                [
                    'unique_id' => $request->unique_id
                ],
                [
                    'exam_id' => $request->exam_id,
                    'unique_id' => $request->unique_id,
                    'answers' => json_encode($request->answers),
                    'attempted' => $request->stats['attempted'],
                    'answered' => $request->stats['answered'],
                    'unanswered' => $request->stats['unanswered'],
                    'score' => $request->stats['score'],
                    'time_remaining' => $request->time_remaining,
                    'time_taken' => $request->time_taken,
                    'submitted_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

        }

        return response()->json([
            'message' => 'Your exam has been submitted successfully!',
            'score' => $request->stats['score']
        ]);

    }
  


}
