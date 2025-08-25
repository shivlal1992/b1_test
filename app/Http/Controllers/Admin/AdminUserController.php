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
use Validation;
use Spatie\Permission\Models\Role;
class AdminUserController extends Controller
{
    public function usersList(Request $request)
    {
        $data = User::with('districtData')->whereHas('roles', function ($query)  {
            $query->where('name', "District Admin");
        })->orderBy("created_at","desc")->get();
        return view('admin.users-list',compact('data'));
    }
    public function registeredUsers(Request $request)
    {
        $data = User::whereHas('roles', function ($query)  {
            $query->where('name', "User");
        })->orderBy("created_at","desc")->get();
        return view('admin.registered-users-list',compact('data'));
    }
    public function userCreate(Request $request)
    {
        $districts = Districts::all();
        return view('admin.user-create',compact('districts'));
    }
    public function userCreatePost(Request $request)
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
        $inputReg['name'] = $request->name;
        $inputReg['phone'] = $request->phone;
        $inputReg['email'] = $request->email;
        $inputReg['password'] = Hash::make($request->password);
        $inputReg['password_text'] = $request->password;
        $inputReg['district_id'] = $request->district_id;
        $inputReg['status'] = $request->status;
        $user =  User::create($inputReg);
        $user->assignRole('District Admin');
        if ($user) {
            return redirect()->route("users")->with("success", "Created Successfully.");
        }
    }
    public function userEdit(Request $request,$id)
    {
        $user = User::with('districtData')->where('id',$id)->first();
        $districts = Districts::all();
        return view('admin.user-edit',compact('user','districts'));
    }
    public function userDelete(Request $request,$id)
    {
        $user = User::where('id',$id)->first();
        if($user){
            $user->forceDelete();
            return redirect()->back()->with("success", "User deleted successfully.");
        }
        return redirect()->back()->with("error", "User not found.");
    }
    public function userUpdate(Request $request)
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
        $user->syncRoles(['District Admin']);
        if ($user) {
            return redirect()->route("users")->with("success", "Update Successfully.");
        }
    }
}
