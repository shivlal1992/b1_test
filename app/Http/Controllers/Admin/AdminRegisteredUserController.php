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
class AdminRegisteredUserController extends Controller
{
    public function list(Request $request)
    {
        
        $data = User::with("createdByData")->whereHas('roles', function ($query)  {
            $query->where('name', "User");
        });
        if(auth()->user()->getRoleNames()[0] == "Registrar"){
            $data = $data->where('created_by',auth()->user()->id);
        }
        if(auth()->user()->getRoleNames()[0] == "District Admin"){
            $data = $data->where('district_id',auth()->user()->district_id);
        }
        $data = $data->orderBy("created_at","desc")->get();
        return view('admin.register-user.list',compact('data'));
    }
    public function create(Request $request)
    {
        $districts = Districts::all();
        return view('admin.register-user.create',compact('districts'));
    }
    public function createPost(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);
        $checkphoneExist = User::where('phone', $request->phone)->first();
        if (!empty($checkphoneExist)) {
            return redirect()->back()->with("error", "User already exists.");
        }

        if (!$request->dob || !Carbon::parse($request->dob)->isValid()) {
            // Invalid date format or null
            return redirect()->back()->with("error", "Invalid or missing date.");
        }
		
		if (!$request->date_of_join || !Carbon::parse($request->date_of_join)->isValid()) {
            // Invalid date format or null
            return redirect()->back()->with("error", "Invalid or missing date.");   
        }

        $age = Carbon::parse($request->dob)->age;

        if ($age < 18) {
             return redirect()->back()->with("error", "User must be at least 18 years old.");
        }
		
		$date_of_join = Carbon::parse($request->date_of_join)->age;       
		if ($date_of_join < 5) {
             return redirect()->back()->with("error", "User requires minimum 5 years of experience");   
        }   


        
        $inputReg = $request->only('name','phone','email','father_name','dob','gender','permanent_address','present_address','aadhar_card','id_card_no','pmis_no','uni_constable_no','date_of_join','is_self_undertaking','form_fill_place','district_id');
        $inputReg['status'] = '1';
        if (isset($request->is_self_undertaking)) {
            $inputReg['is_self_undertaking'] = '1';
        }else{
            $inputReg['is_self_undertaking'] = '0';
        }
       
        if ($request->user_sign) {
            $user_sign_imageName = $request->user_sign->store('/images');
            $inputReg['user_sign'] = 'uploads/' . $user_sign_imageName;
        }
        $inputReg['form_fill_date'] = date("Y-m-d");
        $inputReg['created_by'] = auth()->user()->id;
        $user =  User::create($inputReg);
        if ($user) {
            if ($request->profile_image) {

                $file = $request->file('profile_image');
                $extension = $file->getClientOriginalExtension();
                $filename = $user->id . '.' . $extension;

                $file->move(public_path('uploads/images'), $filename);
                $updateimage['profile_image'] = 'uploads/images/' . $filename;
                $userUpdate =  User::where("id",$user->id)->update($updateimage);
            }
            $user->assignRole('User');
            return redirect()->back()->with("success", "Submitted Succefully.");
        } else {
            return redirect()->back()->with("error", "Failed.");
        }
    }
    public function edit(Request $request,$id)
    {
        $districts = Districts::all();
        $user = User::where('id',$id)->first();
        return view('admin.register-user.edit',compact('user','districts'));
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
     
        if($request->email){
            $exist_email = User::where('id','!=',$request->id)->where('email',$request->email)->first();
            if ($exist_email) {
                return redirect()->back()->with("error", "Email already exists.");
            }
        }
        if($request->phone){
            $exist_phone = User::where('id','!=',$request->id)->where('phone',$request->phone)->first();
            if ($exist_phone) {
                return redirect()->back()->with("error", "Phone already exists.");
            }
        }
    
        if (!$request->dob || !Carbon::parse($request->dob)->isValid()) {
            // Invalid date format or null
            return redirect()->back()->with("error", "Invalid or missing date.");
        }

        $age = Carbon::parse($request->dob)->age;
		$date_of_join = Carbon::parse($request->date_of_join)->age;

        if ($age < 18) {
             return redirect()->back()->with("error", "User must be at least 18 years old.");
        }
		
		if ($date_of_join < 5) {
             return redirect()->back()->with("error", "User requires minimum 5 years of experience");   
        }   

        $inputReg = $request->only('name','phone','email','father_name','dob','gender','permanent_address','present_address','aadhar_card','id_card_no','pmis_no','uni_constable_no','date_of_join','is_self_undertaking','form_fill_place','district_id');
        $inputReg['status'] = '1';
        if (isset($request->is_self_undertaking)) {
            $inputReg['is_self_undertaking'] = '1';
        }else{
            $inputReg['is_self_undertaking'] = '0';
        }
       
        if ($request->user_sign) {
            $user_sign_imageName = $request->user_sign->store('/images');
            $inputReg['user_sign'] = 'uploads/' . $user_sign_imageName;
        }
        if ($request->profile_image) {

             if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }


            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $filename = $user->id . '.' . $extension;

            $file->move(public_path('uploads/images'), $filename);
            $inputReg['profile_image'] = 'uploads/images/' . $filename;
        }
        $userupdate = User::where('id', $request->id)->update($inputReg);
        $user->syncRoles(['User']);
        if ($user) {
            return redirect()->route('registered-users')->with("success", "Update Successfully.");
        }
    }

    public function view(Request $request,$id)
    {
        $user = User::where('id',$id)->first();
        return view('admin.register-user.view',compact('user'));
    }
}
