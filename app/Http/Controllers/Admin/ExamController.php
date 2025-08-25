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
use App\Helpers\Custom_helper;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Storage;
use Str;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\File;


class ExamController extends Controller
{


    public function list(Request $request)
    {
        $data = Exams::orderBy("created_at","desc")->get();
        return view('admin.exams.list',compact('data'));
    }
    public function create(Request $request)
    {
        return view('admin.exams.create');
    }
    public function createPost(Request $request)
    {
        $inputReg['title'] = $request->title;
        $inputReg['date'] = $request->date;
        $data =  Exams::create($inputReg);
        if ($data) {
            return redirect()->route("exams")->with("success", "Created Successfully.");
        }
    }
    public function edit(Request $request,$id)
    {
        $data = Exams::where('id',$id)->first();
        return view('admin.exams.edit',compact('data'));
    }
    public function delete(Request $request,$id)
    {
        $data = Exams::where('id',$id)->first();
        if($data){
            $data->delete();
            return redirect()->back()->with("success", "Data deleted successfully.");
        }
        return redirect()->back()->with("error", "Data not found.");
    }
    public function update(Request $request)
    {
        $data = Exams::where('id', $request->id)->first();
        if (empty($data)) {
            return redirect()->back()->with("error", "Data not found.");
        }
        if($request->title){
            $data->title =$request->title; 
        }
        if($request->date){
            $data->date =$request->date; 
        }
      
        $data->save();
        if ($data) {
            return redirect()->route("exams")->with("success", "Update Successfully.");
        }
    }
   

    public function assignCandidatesToCenters(Request $request,$examId)
    {

        $users = User::where('created_by', auth()->user()->id)->get();

        $assigned = 0;
        $skipped = [];

        foreach ($users as $user) {
            $result = $this->assginAdmitCard($user, $examId);

            if ($result === true) {
                $assigned++;
            } else {
                $skipped[] = $user->name ?? 'User ID ' . $user->id;
            }
        }

        if ($assigned > 0 && count($skipped) === 0) {
            return redirect()->route("exams")
                ->with("success", "$assigned candidate(s) successfully assigned.");
        } elseif ($assigned > 0 && count($skipped) > 0) {
            return redirect()->route("exams")
                ->with("warning", "$assigned assigned. Skipped: " . implode(', ', $skipped));
        } else {
            return redirect()->route("exams")
                ->with("error", "No candidates were assigned. All centers might be full or already assigned.");
        }
    }

    public function assginAdmitCard($user, $examId)
{
    $alreadyAssigned = Exam_allocations::where('user_id', $user->id)
        ->where('exam_id', $examId)
        ->exists();

    if ($alreadyAssigned) {
        return false;
    }

    $centers = Exam_centers::where('district_id', $user->district_id)->get();

    foreach ($centers as $center) {
        $maxSeats = floor($center->capacity_seat * 0.95);
        $totalAssigned = Exam_allocations::where('exam_id', $examId)
            ->where('center_id', $center->id)
            ->count();

        if ($totalAssigned >= floor($maxSeats)) continue;

        // ✅ Always dynamic from exam_centers table
$slot = $center->slot;
$startTime = $center->start_time;
$endTime   = $center->end_time;


        $checkUser = Exam_allocations::where('user_id', $user->id)
            ->where('exam_id', $examId)
            ->where('center_id', $center->id)
            ->first();

        if (empty($checkUser)) {
            $allocation = Exam_allocations::create([
                'unique_id'   => $user->id.'0'.$examId.'0'.rand(10000,99999),
                'user_id'     => $user->id,
                'exam_id'     => $examId,
                'center_id'   => $center->id,
                'slot'        => $slot,
                'start_time'  => $startTime,
                'end_time'    => $endTime,
                'attendance'  => "pending",
                'created_by'  => auth()->user()->id,
            ]);

            $allocationData = Exam_allocations::with(
                "userData",
                "examCenterData.districtData",
                'examData'
            )->where('id', $allocation->id)->first();

            if ($allocationData) {
                $qrDir = storage_path('app/public/qr');
                $pdfDir = storage_path('app/public/pdf');

                if (!File::exists($qrDir)) {
                    File::makeDirectory($qrDir, 0755, true);
                }
                if (!File::exists($pdfDir)) {
                    File::makeDirectory($pdfDir, 0755, true);
                }

                // ✅ File names
                $qrFileName = 'qr_' . $user->id . '_' . Str::random(5) . '.png';
                $pdfFileName = 'admitcard_' . $user->id . '' . $allocation->id . '' . Str::random(5) . '.pdf';

                $qrFilePath = $qrDir . '/' . $qrFileName;
                $pdfFilePath = $pdfDir . '/' . $pdfFileName;

                // ✅ Generate QR code
                Builder::create()
                    ->data($allocationData->unique_id ?? 'No-Data')
                    ->size(200)
                    ->margin(10)
                    ->build()
                    ->saveToFile($qrFilePath);

                // ✅ Check QR file
                if (!File::exists($qrFilePath)) {
                    throw new \Exception("Failed to generate QR code at {$qrFilePath}");
                }

                // ✅ Convert QR to base64 for PDF
                $qrBase64 = base64_encode(file_get_contents($qrFilePath));
                $qrSrc = 'data:image/png;base64,' . $qrBase64;

                // ✅ Prepare PDF data
                $pdfData = [
                    'exam'       => $allocationData->examData,
                    'user'       => $allocationData->userData,
                    'center'     => $allocationData->examCenterData,
                    'allocation' => $allocationData,
                    'qrPath'     => $qrSrc,
                ];

                // ✅ Generate PDF
                $pdf = Pdf::loadView('admin.exams.admitcard', $pdfData);

                // ✅ Save PDF to storage
                Storage::disk('public')->put('pdf/' . $pdfFileName, $pdf->output());

                // ✅ Save URL in database (browser-accessible via storage link)
                $allocationData->admitcard_url = asset('storage/pdf/' . $pdfFileName);
                $allocationData->save();
            }
        }

        return true;
    }

    return false;
}



 
    public function checkpdf(Request $request,$id)
    {
        $allocationData = Exam_allocations::with("userData","examCenterData.districtData",'examData')->where('id', $id)->first();
        // Generate QR code PNG and save to temp file
        $tempFile = storage_path('app/public/qr_temp.png');

        // Clean old file if exists
        if (File::exists($tempFile)) {
            File::delete($tempFile);
        }

        Builder::create()
            ->data('https://example.com')
            ->size(200)
            ->margin(10)
            ->build()
            ->saveToFile($tempFile);

        $pdfdata = [
            'exam' => $allocationData->examData,
            'user' => $allocationData->userData,
            'center' => $allocationData->examCenterData,
            'allocation' => $allocationData,
            'qrPath' => $tempFile
        ];
    
        $pdf = Pdf::loadView('admin.exams.admitcard', $pdfdata); // your Blade view

         // // Optional: Delete after generating PDF (async)
        register_shutdown_function(function () use ($tempFile) {
            if (File::exists($tempFile)) {
                File::delete($tempFile);
            }
        });
        return $pdf->stream('invoice_1001.pdf');
    }


    public function downloadAdmit($filename)
{
    $path = storage_path('app/public/pdf/' . $filename);

    if (!file_exists($path)) {
        abort(404, "Admit card not found.");
    }

    return response()->download($path);
}



   

    public function examCandidates(Request $request,$examid)
    {

        // $data = Exam_allocations::with("userData","examCenterData.districtData",'examData');
        // if(auth()->user()->getRoleNames()[0] == "District Admin"){
        //     $data = $data->where('district_id',auth()->user()->district_id);
        // }
        // $data = $data->where('exam_id', $examid)->get();


        $data = Exam_allocations::with("userData","examCenterData.districtData",'examData','examResultData');
        if(auth()->user()->getRoleNames()[0] == "District Admin" || auth()->user()->getRoleNames()[0] == "Registrar" || auth()->user()->getRoleNames()[0] == "Suprintendent"){
            $data = $data->whereHas('examCenterData.districtData', function ($query)  {
                        $query->where('id', auth()->user()->district_id);
                    });
        }
        $data = $data->where('exam_id', $examid)->get();

        $map = [
            'A' => 'opt_a',
            'B' => 'opt_b',
            'C' => 'opt_c',
            'D' => 'opt_d',
        ];

        foreach ($data as $allocation) {
            if ($allocation->examResultData) {
                $answers = json_decode($allocation->examResultData->answers, true);
                $questionIds = array_keys($answers);

                $questions = Questions::whereIn('id', $questionIds)->get(['id', 'answer']);

                $score = 0;
                $attempted = 0;

                foreach ($questions as $question) {
                    $qid = $question->id;
                    $selected = $answers[$qid] ?? null;

                    if (!empty($selected)) {
                        $attempted++;
                         // Map candidate answer and compare with ENUM
                        if (isset($map[$selected]) && $map[$selected] === $question->answer) {
                            $score += 1;
                        }
                    }
                }

                $total_question = $allocation->examResultData->answered +  $allocation->examResultData->unanswered;
                $allocation->examResultData->total_question = $total_question;
                $allocation->examResultData->score = $score;
                $allocation->examResultData->attempted = $attempted;
                $allocation->examResultData->answered = $attempted;
                $allocation->examResultData->unanswered = count($answers) - $attempted;
                
                $percentage = $total_question > 0 ? round(($score / $total_question) * 100, 2) : 0;
                $allocation->examResultData->percentage = $percentage;
            }
        }



        return view('admin.exams.examCandidatesList',compact('data'));
        
    }
   

    public function attendanceMarking(Request $request,$userid,$examid,$att)
    {
        $data = Exam_allocations::with("userData","examCenterData.districtData",'examData')->where('user_id', $userid)->where('exam_id', $examid)->first();
        if(empty($data)){
            return redirect()->back()->with("error", "Data not available");
        }
        $data->attendance = $att;
        $data->save();
        return redirect()->back()->with("success", "Update Successfully.");
        
    }

  public function meritList($examId)
{
    $exam = Exams::findOrFail($examId);

    $results = DB::table('exam_results')
        ->where('exam_results.exam_id', $examId)
        ->join('exam_allocations', 'exam_allocations.unique_id', '=', 'exam_results.unique_id') // ✅ FIXED
        ->join('users', 'users.id', '=', 'exam_allocations.user_id')
        ->select(
            'exam_results.id',
            'exam_results.score',
            'exam_results.time_taken',
            'exam_results.submitted_at',
            'users.name',
            'users.email'
        )
        ->orderByDesc('exam_results.score')
        ->orderBy('exam_results.time_taken', 'asc')
        ->get();

    // ✅ Assign rank manually
    $results = $results->map(function ($item, $index) {
        $item->rank = $index + 1;
        return $item;
    });

    return view('admin.exams.meritList', compact('exam', 'results'));
}




}