<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Helpers\Custom_helper;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Spatie\Permission\Models\Role;
use App\Models\Districts;
class AdminRegistrarController extends Controller
{
    public function list(Request $request)
    {
        $data = User::whereHas('roles', function ($query)  {
            $query->where('name', "Registrar");
        })->where('created_by',auth()->user()->id)->orderBy("created_at","desc")->get();
        return view('admin.registrar.list',compact('data'));
    }
    public function create(Request $request)
    {
        $districts = Districts::all();
        return view('admin.registrar.create',compact('districts'));
    }
    public function createPost(Request $request)
    {
        $checkphoneExist = User::where('phone', $request->phone)->first();
        if (!empty($checkphoneExist)) {
            return redirect()->back()->with("error", "User already exists.");
        }
        $inputReg['profile_image'] = "uploads/dummy-img.png";
        $inputReg['status'] = '1';
        $inputReg['name'] = $request->name;
        $inputReg['phone'] = $request->phone;
        $inputReg['email'] = $request->email;
        $inputReg['education'] = $request->education;
        $inputReg['password'] = Hash::make($request->password);
        $inputReg['password_text'] = $request->password;
        $inputReg['district_id'] = auth()->user()->district_id;
        $inputReg['created_by'] = auth()->user()->id;

        if ($request->profile_image) {
            $imageName = $request->profile_image->store('/images');
            $inputReg['profile_image'] = 'uploads/' . $imageName;
        }
        $user =  User::create($inputReg);
        $user->assignRole('Registrar');
        if ($user) {
            return redirect()->route("registrars")->with("success", "Created Successfully.");
        }
    }
    public function edit(Request $request,$id)
    {
        $districts = Districts::all();
        $user = User::where('id',$id)->first();
        return view('admin.registrar.edit',compact('user','districts'));
    }
    public function delete(Request $request,$id)
    {
        $user = User::where('id',$id)->first();
        if($user){
            $user->delete();
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
        if($request->education){
            $user->education =$request->education; 
        }
       
        if($request->email){
            $exist_email = User::where('id','!=',$request->id)->where('email',$request->email)->first();
            if ($exist_email) {
                return redirect()->back()->with("error", "Email already exists.");
            }
            $user->email =$request->email; 
        }
        $user->district_id =auth()->user()->district_id; 
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
        if ($request->profile_image) {
            $imageName = $request->profile_image->store('/images');
            $user->profile_image = 'uploads/' . $imageName;
        }
        $user->save();
        $user->syncRoles(['Registrar']);
        if ($user) {
            return redirect()->route("registrars")->with("success", "Update Successfully.");
        }
    }
}
