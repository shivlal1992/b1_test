<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Mock_exams;
use App\Models\Exam_centers;
use App\Models\Exam_allocations;
use App\Models\Mock_exam_results;
use App\Models\Questions;
use App\Models\Districts;
use App\Helpers\Custom_helper;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Str;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\File;


class MockExamController extends Controller
{


    public function list(Request $request)
    {
        $data = Mock_exams::orderBy("created_at","desc")->get();
        return view('admin.mock-exams.list',compact('data'));
    }
    public function create(Request $request)
    {
        return view('admin.mock-exams.create');
    }
    public function createPost(Request $request)
    {
        $inputReg['title'] = $request->title;
        $inputReg['date'] = $request->date;
        $data =  Mock_exams::create($inputReg);
        if ($data) {
            return redirect()->route("mocktests")->with("success", "Created Successfully.");
        }
    }
    public function edit(Request $request,$id)
    {
        $data = Mock_exams::where('id',$id)->first();
        return view('admin.mock-exams.edit',compact('data'));
    }
    public function delete(Request $request,$id)
    {
        $data = Mock_exams::where('id',$id)->first();
        if($data){
            $data->delete();
            return redirect()->back()->with("success", "Data deleted successfully.");
        }
        return redirect()->back()->with("error", "Data not found.");
    }
    public function update(Request $request)
    {
        $data = Mock_exams::where('id', $request->id)->first();
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
            return redirect()->route("mocktests")->with("success", "Update Successfully.");
        }
    }
   

    public function examCandidates(Request $request,$examid)
    {

        
        // Mapping candidate answers to ENUM
        $map = [
            'A' => 'opt_a',
            'B' => 'opt_b',
            'C' => 'opt_c',
            'D' => 'opt_d',
        ];
        $data = Mock_exam_results::with("userData",'examData')->where('exam_id', $examid)->get();

        
        foreach ($data as $result) {
            $answers = json_decode($result->answers, true); // ["2"=>null,"3"=>"B",...]
            $questionIds = array_keys($answers);

            // Fetch correct answers for these questions
            $questions = Questions::whereIn('id', $questionIds)->get(['id', 'answer']);

            $score = 0;
            $attempted = 0;

            foreach ($questions as $question) {
                $qid = $question->id;
                $selected = $answers[$qid] ?? null;

                if (!empty($selected)) {
                    $attempted++;
                    // Compare candidate answer with ENUM answer
                    if (isset($map[$selected]) && $map[$selected] === $question->answer) {
                        $score += 1;
                    }
                }
            }
            $totalQuestions = $result->answered + $result->unanswered;
            $percentage = $totalQuestions > 0 ? round(($score / $totalQuestions) * 100, 2) : 0;

            $result->score = $score;
            $result->percentage = $percentage;
            $result->total_questions = $totalQuestions;
                
        }


        return view('admin.mock-exams.examCandidatesList',compact('data'));
        
    }
   

}
