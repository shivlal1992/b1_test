<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Districts;
use App\Helpers\Custom_helper;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Spatie\Permission\Models\Role;
class DistrictController extends Controller
{
    public function list(Request $request)
    {
        $data = Districts::orderBy("created_at","desc")->get();
        return view('admin.district.list',compact('data'));
    }
    public function create(Request $request)
    {
        return view('admin.district.create');
    }
    public function createPost(Request $request)
    {
        $inputReg['title'] = $request->title;
        $data =  Districts::create($inputReg);
        if ($data) {
            return redirect()->route("districts")->with("success", "Created Successfully.");
        }
    }
    public function edit(Request $request,$id)
    {
        $data = Districts::where('id',$id)->first();
        return view('admin.district.edit',compact('data'));
    }
    public function delete(Request $request,$id)
    {
        $data = Districts::where('id',$id)->first();
        if($data){
            $data->delete();
            return redirect()->back()->with("success", "Data deleted successfully.");
        }
        return redirect()->back()->with("error", "Data not found.");
    }
    public function update(Request $request)
    {
        $data = Districts::where('id', $request->id)->first();
        if (empty($data)) {
            return redirect()->back()->with("error", "Data not found.");
        }
        if($request->title){
            $data->title =$request->title; 
        }
      
        $data->save();
        if ($data) {
            return redirect()->route("districts")->with("success", "Update Successfully.");
        }
    }
}
