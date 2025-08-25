<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Districts;
use App\Models\Exam_centers;
use App\Helpers\Custom_helper;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Validation;
use Spatie\Permission\Models\Role;
class SupridentController extends Controller
{
    public function list(Request $request)
    {
        $data = User::with('districtData','examCenterData')->whereHas('roles', function ($query)  {
            $query->where('name', "Suprintendent");
        })->orderBy("created_at","desc")->where('created_by',auth()->user()->id)->get();
        return view('admin.suprident.list',compact('data'));
    }
    
    public function create(Request $request)
    {
        $districts = Districts::all();
        $exam_centers = Exam_centers::all();   
        return view('admin.suprident.create',compact('districts','exam_centers'));
    }
    public function createPost(Request $request)
    {
        $checkphoneExist = User::where('phone', $request->phone)->first();
        if (!empty($checkphoneExist)) {
            return redirect()->back()->with("error", "Phone already exists.");
        }
        $checkphoneExist = User::where('email', $request->email)->first();
        if (!empty($checkphoneExist)) {
            return redirect()->back()->with("error", "Email already exists.");
        }
        $inputReg['profile_image'] = "uploads/dummy-img.png";
        $inputReg['status'] = '1';
        $inputReg['exam_center_id'] = $request->exam_center_id;
        $inputReg['name'] = $request->name;
        $inputReg['phone'] = $request->phone;
        $inputReg['email'] = $request->email;
        $inputReg['password'] = Hash::make($request->password);
        $inputReg['password_text'] = $request->password;
        $inputReg['district_id'] = $request->district_id;
        $inputReg['status'] = $request->status;
        $inputReg['created_by'] = auth()->user()->id;
        $user =  User::create($inputReg);
        $user->assignRole('Suprintendent');
        if ($user) {
            return redirect()->route("suprintendent")->with("success", "Created Successfully.");
        }
    }
    public function edit(Request $request,$id)
    {
        $user = User::with('districtData')->where('id',$id)->first();
        $districts = Districts::all();
        $exam_centers = Exam_centers::all();   
        return view('admin.suprident.edit',compact('user','districts','exam_centers'));
    }
    public function delete(Request $request,$id)
    {
        $user = User::where('id',$id)->first();
        if($user){
            $user->forceDelete();
            return redirect()->back()->with("success", "User deleted successfully.");
        }
        return redirect()->back()->with("error", "User not found.");
    }
    public function update(Request $request)
    {
      
        $user = User::where('id', $request->id)->first();
        if (empty($user)) {
            return redirect()->back()->with("error", "User not found.");
        }
        if($request->name){
            $user->name =$request->name; 
        }
        if($request->district_id){
            $user->district_id =$request->district_id; 
        }
        if($request->exam_center_id){
            $user->exam_center_id =$request->exam_center_id; 
        }
        if($request->district){
            $user->district =$request->district; 
        }
        if(isset($request->status)){
            $user->status = $request->status; 
        }
        if($request->email){
            $exist_email = User::where('id','!=',$request->id)->where('email',$request->email)->first();
            if ($exist_email) {
                return redirect()->back()->with("error", "Email already exists.");
            }
            $user->email =$request->email; 
        }
        if($request->phone){
            $exist_phone = User::where('id','!=',$request->id)->where('phone',$request->phone)->first();
            if ($exist_phone) {
                return redirect()->back()->with("error", "Phone already exists.");
            }
            $user->phone =$request->phone; 
        }
        if($request->password){
            $user->password_text =$request->password; 
            $user->password =Hash::make($request->password); 
        }
        $user->save();
        $user->syncRoles(['Suprintendent']);
        if ($user) {
            return redirect()->route("suprintendent")->with("success", "Update Successfully.");
        }
    }
}
