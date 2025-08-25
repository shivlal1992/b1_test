<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\User_plans;
use App\Models\Transactions;
use App\Models\Exam_allocations;
use Carbon\Carbon;
use Auth;
use App\Helpers\Custom_helper;
use DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
class AuthController extends Controller
{
  
    
    public function pythonApi(Request $request)
    {
        \Log::info('pythonApi - Request Data:', $request->all());

        return true;
    }
    
    public function pythonApiMarkAttendance(Request $request)
    {
        \Log::info('pythonApiMarkAttendance - Request Data:', $request->all());

        
        $data = Exam_allocations::where('unique_id', $request->roll_no)->first();
        if(!empty($data)){
            $data->attendance = "available";
            $data->save();
            return response()->json($data);
        }
        return "false";
    }

    public function loginPage()
    {
        if(auth()->user()){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }
    public function registerPage()
    {
        if(auth()->user()){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.register');
    }
    public function forgotPasswordPage()
    {
        if(auth()->user()){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.forgot-password');
    }
    public function resetPasswordPage(Request $request)
    {
        if(auth()->user()){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.reset-password');
    }
    public function checkAndVerify(Request $request)
    {
        if(auth()->user()){
            return redirect()->route('admin.dashboard');
        }
        $user = User::where('phone', $request->phone)
                ->where('unique_id',$request->unique_id)
                ->whereNull('deleted_at')
                ->first();
        if(!empty($user)){
            // return view('admin.reset-password',compact('user'));
            return redirect()->route('admin.reset-password',['phone'=>$user->phone]);
        }else{
            return redirect()->back()->with("error", "Oppes! You have entered invalid details.");
        }
    }
    public function resetPassword(Request $request)
    {
        if(auth()->user()){
            return redirect()->route('admin.dashboard');
        }
        $user = User::where('phone', $request->phone)
                ->whereNull('deleted_at')
                ->first();
        if(!empty($user)){
            if($request->password != $request->confirm_password){
                return redirect()->back()->with("error", "New password and confirm password should be same.");
            }
            $user->password_text =$request->password; 
            $user->password =Hash::make($request->password); 
            $user->save(); 
            return redirect()->route('admin.login')->with("success", "Password update successfully.");
        }else{
            return redirect()->back()->with("error", "User not found.");
        }
    }
    public function loginPost(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);
        $password = $request->password;
        $username = $request->phone;
        $user = User::where('phone', $username)
                ->where('status', '1')
                ->whereNull('deleted_at')
                ->first();
        if (Auth::attempt(['phone'=>$username,'password'=>$password])) {
            if(auth()->user()->status == '0'){
                Auth::logout();
                return redirect()->back()->with("error", "This account has been deactivated and is no longer accessible.");
            }
            return redirect()->route("admin.dashboard");
        }else{
            $user = User::where('phone', $username)
                ->whereNull('deleted_at')
                ->first();
            if ($user) {
                if (!Hash::check($password, $user->password)) {
                    return redirect()->back()->with("error", "Login Fail, Please check your password.");
                }
                return redirect()->back()->with("error", "Oppes! You have entered invalid credentials.");
            } else {
                return redirect()->back()->with("error", "User Not Found.");
            }
        }
    }
    public function registerPost(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);
        $checkphoneExist = User::where('role_id', "2")->where('phone', $request->phone)->first();
        if (!empty($checkphoneExist)) {
            return redirect()->back()->with("error", "User already exists.");
        }
        $inputReg = $request->only('phone','referral_by_code');
        $inputReg['profile_image'] = "uploads/dummy-img.png";
        $inputReg['role_id'] = "2";
        $inputReg['is_terminate'] = '0';
        $inputReg['status'] = '1';
        $inputReg['first_invest_amt'] = 0;
        $inputReg['referral_code'] = "BET".rand(10000000,99999999);
        $inputReg['unique_id'] = "BET".rand(100,999).date("dmYhis");
        $inputReg['name'] = $inputReg['referral_code'];
        $inputReg['password'] = Hash::make($request->password);
        $inputReg['password_text'] = $request->password;
        $user =  User::create($inputReg);
        if ($user) {
            Auth::loginUsingId($user->id);
            return redirect()->route("admin.dashboard");
        } else {
            return redirect()->back()->with("error", "Failed.");
        }
    }
    public function userRegistrationPage()
    {
        if(auth()->user()){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.register');
    }
    public function userRegistrationPost(Request $request)
    {
        // print_r($request->all());exit;
        $request->validate([
            'phone' => 'required',
        ]);
        $checkphoneExist = User::where('phone', $request->phone)->first();
        if (!empty($checkphoneExist)) {
            return redirect()->back()->with("error", "User already exists.");
        }
        $inputReg = $request->only('name','phone','email','father_name','dob','gender','permanent_address','present_address','aadhar_card','id_card_no','pmis_no','uni_constable_no','date_of_join','is_self_undertaking','form_fill_date','form_fill_place','district');
        $inputReg['status'] = '1';
        if (isset($request->is_self_undertaking)) {
            $inputReg['is_self_undertaking'] = '1';
        }else{
            $inputReg['is_self_undertaking'] = '0';
        }
        if ($request->profile_image) {
            $imageName = $request->profile_image->store('/images');
            $inputReg['profile_image'] = 'uploads/' . $imageName;
        }
        if ($request->user_sign) {
            $user_sign_imageName = $request->user_sign->store('/images');
            $inputReg['user_sign'] = 'uploads/' . $user_sign_imageName;
        }
        $user =  User::create($inputReg);
        if ($user) {
            $user->assignRole('User');
            return redirect()->back()->with("success", "Submitted Succefully.");
        } else {
            return redirect()->back()->with("error", "Failed.");
        }
    }
}
