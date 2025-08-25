<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Helpers\Custom_helper;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Str;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Districts;
use App\Models\Questions;
use App\Models\Mock_exams;
use App\Models\Mock_exam_attempts;
use App\Models\Mock_exam_results;


class MockTestController extends Controller
{
    public function index(Request $request,$id)
    {
        $scheduledExam = DB::table('exams')
            ->whereDate('date', '>', now())
            ->orderBy('date', 'asc')
            ->first();

        if (!$scheduledExam) {
            abort(403, 'No exam is scheduled yet.');
        }

        $examDate = Carbon::parse($scheduledExam->date);
        $daysLeft = now()->startOfDay()->diffInDays($examDate->startOfDay(), false);
        // Allow only if 1–4 days are left before exam
        // if ($daysLeft < 1 || $daysLeft > 4) {
        //     abort(403, 'Mock test is accessible only within 4 days before the exam.');
        // }

        return view('admin.online-exam.mock-exam',compact('id'));
    }
  
    public function validateCandidate(Request $request)
    {
        $data = User::where('id',$request->unique_id)->where('status','1')->first();
        if(!empty($data)){
            $attempts = Mock_exam_attempts::where('unique_id', $request->unique_id)
            ->orderBy('id', 'asc')
            ->first();

            // if(!empty($attempts)){
            //     return response()->json(['valid' => false,'is_attempt'=>1]);
            // }
            return response()->json(['valid' => true]);
        }else{
            return response()->json(['valid' => false]);
        }
    }

   
    public function fetchQuestions(Request $request)
    {
        $uniqueId = $request->unique_id;

        $allQuestions = Questions::take(25)->get(['id', 'title', 'opt_a', 'opt_b', 'opt_c', 'opt_d']);

        $attempts = Mock_exam_attempts::where('unique_id', $uniqueId)
            ->orderBy('id', 'asc') 
            ->get(['question_id', 'selected_option','time_remaining']);

        $attemptedIds = $attempts->pluck('question_id')->toArray();
        $selectedAnswers = $attempts->pluck('selected_option', 'question_id')->toArray();

        $attemptedQuestions = $allQuestions->whereIn('id', $attemptedIds)->values();
        $remainingQuestions = $allQuestions->whereNotIn('id', $attemptedIds)->shuffle()->values();

        if ($remainingQuestions->isEmpty()) {
            $finalQuestions = $attemptedQuestions;
        } else {
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
        return Mock_exam_attempts::where('unique_id', $request->unique_id)
            ->orderBy('time_remaining', 'asc')
            ->get(['question_id', 'selected_option', 'time_remaining']);
    }

    public function saveEachAttempt(Request $request)
    {
        Mock_exam_attempts::updateOrInsert(
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
            Mock_exam_results::updateOrCreate(
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

    // 🔹 NEW METHOD: Merit List
// public function merit($id)
// {
//     $exam = Mock_exams::findOrFail($id);

//     $results = Mock_exam_results::where('exam_id', $id)
//         ->join('users', 'users.id', '=', 'mock_exam_results.unique_id')
//         ->select(
//             'mock_exam_results.*',
//             'users.first_name',
//             'users.last_name',
//             'users.email'
//         )
//         ->orderBy('mock_exam_results.score', 'desc')
//         ->orderBy('mock_exam_results.time_taken', 'asc') // tie-breaker
//         ->get();

//     return view('admin.mock-exams.merit-list', compact('exam', 'results'));
// }


public function merit($id)
{
    $exam = Mock_exams::findOrFail($id);

    $results = Mock_exam_results::where('exam_id', $id)
        ->join('users', 'users.id', '=', 'mock_exam_results.unique_id')
        ->select(
            'mock_exam_results.*',
            'users.name',   // ✅ use "name" instead of first_name + last_name
            'users.email'
        )
        ->orderBy('mock_exam_results.score', 'desc')
        ->orderBy('mock_exam_results.time_taken', 'asc') // tie-breaker
        ->get();

    return view('admin.mock-exams.merit-list', compact('exam', 'results'));
}




}
