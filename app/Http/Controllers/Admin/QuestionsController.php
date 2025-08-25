<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Districts;
use App\Models\Questions;
use App\Models\Test_subjects;
use App\Helpers\Custom_helper;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Spatie\Permission\Models\Role;
class QuestionsController extends Controller
{
    public function list(Request $request)
    {
        $test_subjects = Test_subjects::orderBy("id","asc")->get();
        $data = Questions::with("subjectData");
        if($request->question){
            
            $data = $data->where("title", 'like', "%".$request->question."%");
        }
        if($request->subject_id){
            $data = $data->where("subject_id",$request->subject_id);
        }
        if($request->difficulty_level){
            $data = $data->where("difficulty_level",$request->difficulty_level);
        }
        $data = $data->orderBy("created_at","desc")->get();
        return view('admin.questions.list',compact('data','test_subjects'));
    }
    public function create(Request $request)
    {
        
        $test_subjects = Test_subjects::orderBy("id","asc")->get();
        return view('admin.questions.create',compact('test_subjects'));
    }
    public function createPost(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
        ]);
       
        $inputReg = $request->only('subject_id',	'title',	'opt_a',	'opt_b',	'opt_c',	'opt_d',	'answer',	'difficulty_level');
        $data =  Questions::create($inputReg);
        if ($data) {
            return redirect()->route('questions')->with("success", "Created Successfully.");
        } else {
            return redirect()->back()->with("error", "Failed.");
        }
    }
    public function edit(Request $request,$id)
    {
        $data = Questions::where('id',$id)->first();
        $test_subjects = Test_subjects::orderBy("id","asc")->get();
        return view('admin.questions.edit',compact('data','test_subjects'));
    }
    public function delete(Request $request,$id)
    {
        $data = Questions::where('id',$id)->first();
        if($data){
            $data->delete();
            return redirect()->back()->with("success", "Data deleted successfully.");
        }
        return redirect()->back()->with("error", "Data not found.");
    }
    public function update(Request $request)
    {
        $data = Questions::where('id', $request->id)->first();
        if (empty($data)) {
            return redirect()->back()->with("error", "Data not found.");
        }
     

        $inputReg = $request->only('subject_id',	'title',	'opt_a',	'opt_b',	'opt_c',	'opt_d',	'answer',	'difficulty_level');
        $data = Questions::where('id', $request->id)->update($inputReg);
        if ($data) {
            return redirect()->route('questions')->with("success", "Update Successfully.");
        }
    }

    public function view(Request $request,$id)
    {
        $data = Questions::with("subjectData")->where('id',$id)->first();
        return view('admin.questions.view',compact('data'));
    }

}
