<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Districts;
use App\Models\Exam_centers;
use App\Models\Exams;   
use App\Helpers\Custom_helper;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Spatie\Permission\Models\Role;

class ExamCenterController extends Controller
{
    public function list(Request $request)
    {
        $data = Exam_centers::with("createdByData","districtData");
        //  if(auth()->user()->getRoleNames()[0] == "Registrar"){
        //     $data = $data->where('created_by',auth()->user()->id);
        // }
        if(auth()->user()->getRoleNames()[0] == "District Admin"|| auth()->user()->getRoleNames()[0] == "Registrar"){
            $data = $data->where('district_id',auth()->user()->district_id);
        }
        $data = $data->orderBy("created_at","desc")->get();
        return view('admin.exam-center.list',compact('data'));
    }

    public function create(Request $request)
    {
        $exams = Exams::all();   
        $districts = Districts::all();   
        return view('admin.exam-center.create',compact('exams','districts'));      
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'location' => 'required',
        ]);
       
        $inputReg = $request->only(
            'location','lat','long','facilities','capacity_seat',
            'logistics','district_id','slot','start_time','end_time'
        );
        // $inputReg['district_id'] = auth()->user()->district_id;
        $inputReg['created_by'] = auth()->user()->id;

        $data =  Exam_centers::create($inputReg);
        if ($data) {
            return redirect()->route('exam-centers')->with("success", "Created Successfully.");
        } else {
            return redirect()->back()->with("error", "Failed.");
        }
    }

    public function edit(Request $request,$id)
    {
        $data = Exam_centers::where('id',$id)->first();
        $districts = Districts::all();
        return view('admin.exam-center.edit',compact('data','districts'));
    }

    public function delete(Request $request,$id)
    {
        $data = Exam_centers::where('id',$id)->first();
        if($data){
            $data->delete();
            return redirect()->back()->with("success", "Data deleted successfully.");
        }
        return redirect()->back()->with("error", "Data not found.");
    }

    public function update(Request $request)
    {
        $data = Exam_centers::where('id', $request->id)->first();
        if (empty($data)) {
            return redirect()->back()->with("error", "Data not found.");
        }
     
        $inputReg = $request->only(
            'location','lat','long','facilities','capacity_seat',
            'logistics','district_id','slot','start_time','end_time'
        );
        // $inputReg['district_id'] = auth()->user()->district_id;

        $data = Exam_centers::where('id', $request->id)->update($inputReg);
        if ($data) {
            return redirect()->route('exam-centers')->with("success", "Update Successfully.");
        }
    }

    public function view(Request $request,$id)
    {
        $data = Exam_centers::with("districtData")->where('id',$id)->first();
        return view('admin.exam-center.view',compact('data'));
    }

}
