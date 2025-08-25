<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Plans;
use App\Models\Transactions;
use App\Models\Bonuses;
use App\Models\Tasks;
use App\Models\User_kyc_requests;
use App\Models\User_plans;
use App\Models\User_bonuses;
use App\Models\User_tasks;
use App\Models\User_withdrawal_requests;
use App\Models\User_daily_incomes;
use App\Models\User_tickets;
use App\Models\User_notifications;
use App\Helpers\Custom_helper;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;



class DashboardController extends Controller
{

   
    public function dashboard()
    {
        
        $total_District_Admin = User::whereHas('roles', function ($query)  {
            $query->where('name', "District Admin");
        })->count();
        
        $total_Registrar = User::whereHas('roles', function ($query)  {
            $query->where('name', "Registrar");
        });
        // if (auth()->user() && !auth()->user()->hasRole('Super Admin')) {
        //     $total_Registrar = $total_Registrar->where('created_by',auth()->user()->id);
        // }
        $total_Registrar = $total_Registrar->count();
        
        $total_User = User::whereHas('roles', function ($query)  {
            $query->where('name', "User");
        });
        if (auth()->user() && !auth()->user()->hasRole('Super Admin')) {
            $total_User = $total_User->where('created_by',auth()->user()->id);
        }
        $total_User = $total_User->count();
        
        return view('admin.dashboard',compact('total_District_Admin','total_Registrar','total_User'));
    }
    public function receiveIncome(Request $request)
    {

        $checkUserPlan =  User_plans::where("user_id",auth()->user()->id)->where("status","in-process")->first();

        if(!empty($checkUserPlan)){

            $getAnyReferal = User::where('referral_by_code',auth()->user()->referral_code)->first();
            if(empty($getAnyReferal)){
                if(auth()->user()->total_task_assgined > 50){
                    $data = ""; 
                    return view('admin.receive-income',compact('data'));   
                }
            }
            
            // $data = Tasks::orderBy("created_at","desc")->get()->take(1);
            $data = Tasks::getDailyTask();

            // foreach ($data as $key => $value) {
                $check =  User_tasks::where("task_id",$data->id)->where("user_id",auth()->user()->id)->first();
                if(!empty($check)){
                    $data->isCompleted = 1;
                }else{
                    $data->isCompleted = 0;
    
                }
                
            // }

            
        }else{
            $data = "";    
        }
        

        return view('admin.receive-income',compact('data'));
    }
    public function myTeam(Request $request)
    {

        $data = User::where('referral_by_code',auth()->user()->referral_code)->get();
        $totalRefer = User::where('referral_by_code',auth()->user()->referral_code)->count();
        // $totalReferIncome = User::where('referral_by_code',auth()->user()->referral_code)->sum('first_invest_amt');
        $totalReferIncome =  Transactions::where("user_id",auth()->user()->id)->where("txn_type","bonus")->where("type","credit")->sum('amount');
        $total_active_user = User::where('referral_by_code',auth()->user()->referral_code)->where("first_invest_amt","!=",0)->count();
        $total_inactive_user = User::where('referral_by_code',auth()->user()->referral_code)->where("first_invest_amt",0)->count();


        $userId = auth()->user()->referral_code;
    
        $teamA = $this->getReferredUsers($userId); // Direct referrals (Team A)
        $teamB = collect(); // Use collections for easier handling
        $teamC = collect();
    
        foreach ($teamA as $user) {
            $teamBUsers = $this->getReferredUsers($user->referral_code);
            $teamB = $teamB->merge($teamBUsers); // Merge collection
    
            foreach ($teamBUsers as $teamBUser) {
                $teamCUsers = $this->getReferredUsers($teamBUser->referral_code);
                $teamC = $teamC->merge($teamCUsers); // Merge collection
            }
        }
    

        return view('admin.my-team',compact('data','totalRefer','total_active_user','total_inactive_user','totalReferIncome','teamA', 'teamB', 'teamC'));
    }

    private function getReferredUsers($referralCode)
    {
        $data = User::with("userPlans")->where('referral_by_code', $referralCode)
            ->get(['id', 'name','phone','unique_id', 'referral_code']);

            
        return $data;
    }


    public function plans(Request $request)
    {
        $data = Plans::orderBy("position","asc")->get();
        foreach ($data as $key => $value) {
            $check =  User_plans::where("plan_id",$value->id)->where("status","in-process")->where("user_id",auth()->user()->id)->first();
            if(!empty($check)){
                $value->isPurchased = 1;
            }else{
                $value->isPurchased = 0;

            }
            
        }
        return view('admin.plans',compact('data'));
    }
    public function myProfile(Request $request)
    {
        $data = User::with("districtData")->where("id",auth()->user()->id)->first();
        return view('admin.my-profile',compact('data'));
    }
    public function kyc(Request $request)
    {
        return view('admin.kyc-form');
    }
    public function changePassword(Request $request)
    {
        return view('admin.change-password');
    }
    public function transactions(Request $request)
    {
        $data = Transactions::where("user_id",auth()->user()->id)->get();
        return view('admin.transactions',compact('data'));
    }
    public function bonus(Request $request)
    {
        $all_referal_active_user = User::where('referral_by_code',auth()->user()->referral_code)
                                        ->where("first_invest_amt","!=",0)
                                        ->select('first_invest_amt_plan_id', \DB::raw('COUNT(*) as total_users'))
                                        ->groupBy('first_invest_amt_plan_id')
                                        ->get();

        $data = Bonuses::orderBy("amount","asc")->get();
        foreach ($data as $key => $value) {
            $total_active_user = User::where('referral_by_code',auth()->user()->referral_code)->where("first_invest_amt","!=",0)->count();
            
            // $check =  User_bonuses::where("bonus_id",$value->id)->where("user_id",auth()->user()->id)->first();
            // if(!empty($check)){
            //     $value->isPurchased = 1;
            // }else{
            //     $value->isPurchased = 0;

            // }
            
        }
        return view('admin.bonus',compact('data','all_referal_active_user'));
    }
   
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route("admin.login");
    }

    public function updateProfile(Request $request)
    {
        $user = User::where('id',auth()->user()->id)->first();
        
        if($request->name){
            $user->name =$request->name; 
        }
        if($request->email){
            $exist_email = User::where('id','!=',auth()->user()->id)->where('email',$request->email)->first();
            if ($exist_email) {
                return redirect()->back()->with("error", "Email already exists.");
            }
            $user->email =$request->email; 
        }
        if($request->phone){
            $exist_phone = User::where('id','!=',auth()->user()->id)->where('phone',$request->phone)->first();
            if ($exist_phone) {
                return redirect()->back()->with("error", "Phone already exists.");
            }
            $user->phone =$request->phone; 
        }
        if($request->trust_address){
            $user->trust_address =$request->trust_address; 
        }
        if($request->aadhar_card){
            $user->aadhar_card =$request->aadhar_card; 
        }
        if($request->state){
            $user->state =$request->state; 
        }
        if($request->city){
            $user->city =$request->city; 
        }
        if($request->pin_code){
            $user->pin_code =$request->pin_code; 
        }
       
        if($request->password){
            $user->password_text =$request->password; 
            $user->password =Hash::make($request->password); 
        }

        if(!empty($request->name) && !empty($request->email) && !empty($request->phone) && !empty($request->trust_address) && !empty($request->aadhar_card) && !empty($request->state) && !empty($request->city) && !empty($request->pin_code) ){
            $user->is_kyc_done ='1'; 
        }

        $user->save();
        if ($user) {
            return redirect()->back()->with("success", "Update Successfully.");
        }
        
    }


    public function submitKyc(Request $request)
    {
        $checkRequest = User_kyc_requests::where('user_id',auth()->user()->id)->first();
        
        if ($checkRequest) {
            return redirect()->back()->with("error", "You have already submitted kyc request.");
        }

        $inputReg = $request->only('name','email','phone','trust_address','state','city','pin_code','aadhar_card');
        $inputReg['user_id'] =auth()->user()->id;
        $inputReg['status'] = 'pending';
        $insert =  User_kyc_requests::create($inputReg);

        if ($insert) {
            return redirect()->back()->with("success", "Your request has been under process wait for 48 to 72 hours.");
        }
        
    }
    
    
    public function deleteKYC(Request $request,$id)
    {
        $checkRequest = User_kyc_requests::where('id',$id)->first();
        
        if (empty($checkRequest)) {
            return redirect()->back()->with("error", "Data not available.");
        }
        $checkRequest->delete();
        return redirect()->back()->with("success", "Request deleted successfully.");

        
    }

    public function kycRequests(Request $request)
    {
        $data = User_kyc_requests::with("userData")->orderBy("created_at","desc")->get();
        return view('admin.kyc-requests',compact('data'));
    }

    public function updateKycRequests(Request $request,$id)
    {
        $kycdata = User_kyc_requests::where('id',$id)->first();
        if(empty($kycdata)){
            return redirect()->back()->with("success", "Data not available.");
        }
        

        $user = User::where('id',$kycdata->user_id)->first();
        if($kycdata->name){
            $user->name =$kycdata->name; 
        }
        if($kycdata->email){
            $exist_email = User::where('id','!=',$kycdata->user_id)->where('email',$kycdata->email)->first();
            if ($exist_email) {
                return redirect()->back()->with("error", "Email already exists.");
            }
            $user->email =$kycdata->email; 
        }
        if($kycdata->phone){
            $exist_phone = User::where('id','!=',$kycdata->user_id)->where('phone',$kycdata->phone)->first();
            if ($exist_phone) {
                return redirect()->back()->with("error", "Phone already exists.");
            }
            $user->phone =$kycdata->phone; 
        }
        if($kycdata->trust_address){
            $user->trust_address =$kycdata->trust_address; 
        }
        if($kycdata->aadhar_card){
            $user->aadhar_card =$kycdata->aadhar_card; 
        }
        if($kycdata->state){
            $user->state =$kycdata->state; 
        }
        if($kycdata->city){
            $user->city =$kycdata->city; 
        }
        if($kycdata->pin_code){
            $user->pin_code =$kycdata->pin_code; 
        }
      

        if(!empty($kycdata->name) && !empty($kycdata->email) && !empty($kycdata->phone) && !empty($kycdata->trust_address) && !empty($kycdata->aadhar_card) && !empty($kycdata->state) && !empty($kycdata->city) && !empty($kycdata->pin_code) ){
            $user->is_kyc_done ='1'; 
        }
        $kycdata->status = "approved";
        $kycdata->save();

        $user->save();
        if ($user) {
            return redirect()->back()->with("success", "Update Successfully.");
        }
    }


    public function getPlan(Request $request,$id)
    {
        $plan_data = Plans::where('id',$id)->first();
        
        $checkPlan = User_plans::with("userData",'planData')->where('user_id',auth()->user()->id)->where('status',"pending")->where("admin_status","pending")->first();
        if(!empty($checkPlan)){
            return redirect()->back()->with("error", "Plan request already exists.");
        }

        $inputReg['user_id'] = auth()->user()->id;
        $inputReg['plan_id'] = $id;
        $inputReg['amount'] = $plan_data->amount;
        $inputReg['status'] = "pending"; //pending, in-process, expired
        $inputReg['admin_status'] = "pending"; // pending, approved, rejected
        $insert =  User_plans::create($inputReg);

        if ($insert) {
            return redirect()->back()->with("success", "Request Submitted.");
        }
        return redirect()->back()->with("error", "Failed.");
    }


    public function planRequests(Request $request)
    {
        $allPlans = User_plans::with("userData",'planData')->where('status',"pending")->where("admin_status","pending")->get();
        return view('admin.all-plans',compact('allPlans'));
    }

    
    // Helper function to get bonus amount
    private function getDailyBonus($package)
    {
        $bonusTable = [
            60    => 1,
            120   => 6,
            250   => 15,
            500   => 25,
            1000  => 50,
            2000  => 100,
            5000  => 200,
            10000 => 500
        ];

        return $bonusTable[$package] ?? 0;
    }
    
    public function planUpdateStatusAdmin(Request $request,$id,$status)
    {
        $plan_data = User_plans::where('id',$id)->first();
        
        if($status == "approved"){
            $plan_data->status = "in-process"; //pending, in-process, expired
        }
        $plan_data->admin_status = $status; // pending, approved, rejected
        $plan_data->save();

        
        if ($plan_data) {
            $plan_data_org = Plans::where('id',$plan_data->plan_id)->first();
            if($status == "approved"){

                $checkFirstTxn = Transactions::where("user_id",$plan_data->user_id)->first();
    
    
                if(empty($checkFirstTxn)){
                    $updateUser = User::where("id",$plan_data->user_id)->update(["first_invest_amt"=>$plan_data->amount,"first_invest_amt_plan_id"=>$plan_data->plan_id]);
                    $userdata = User::where("id",$plan_data->user_id)->first();
                    
                    $checkBonusAmountuser = User::where("referral_code",$userdata->referral_by_code)->first();
                    if($checkBonusAmountuser){
    
                        $bonusamount = ($plan_data->amount * $plan_data_org->bonus_percent)/100;
        
                        @$checkFundBalamount = Custom_helper::checkFundBal($checkBonusAmountuser->id);
                        if ($checkFundBalamount >= 60) {
                            $inputTxnBonus['user_id'] = $checkBonusAmountuser->id;
                            $inputTxnBonus['title'] = "Bonus Credit";
                            $inputTxnBonus['amount'] = $bonusamount;
                            $inputTxnBonus['type'] = "credit";
                            $inputTxnBonus['txn_type'] = "bonus";
                            $insertBonus =  Transactions::create($inputTxnBonus);
                        }
                    }


                }


                $checkDepositeBonus = Transactions::where("user_id",$plan_data->user_id)->where("txn_type","deposit_bonus")->where("description",$plan_data->amount)->first();

                if(empty($checkDepositeBonus)){
                    $debonusAmount = $this->getDailyBonus($plan_data->amount);
                    $inputTxnBonusDeposite['user_id'] = $plan_data->user_id;
                    $inputTxnBonusDeposite['title'] = "Deposit Bonus Credit";
                    $inputTxnBonusDeposite['amount'] = $debonusamount;
                    $inputTxnBonusDeposite['type'] = "credit";
                    $inputTxnBonusDeposite['txn_type'] = "deposit_bonus";
                    $inputTxnBonusDeposite['description'] = $plan_data->amount;
                    $insertDepositeBonus =  Transactions::create($inputTxnBonusDeposite);
                }
            }

            return redirect()->back()->with("success", "Updated Successfully.");
        }
        return redirect()->back()->with("error", "Failed.");
    }
    
    public function getBonus(Request $request,$id)
    {
        $bonus_data = Bonuses::where('id',$id)->first();
        
        $inputReg['user_id'] = auth()->user()->id;
        $inputReg['bonus_id'] = $id;
        $inputReg['amount'] = $bonus_data->amount;
        $insert =  User_bonuses::create($inputReg);

        if ($insert) {

            $inputTxn['user_id'] = auth()->user()->id;
            $inputTxn['title'] = $bonus_data->title;
            $inputTxn['amount'] = $bonus_data->amount;
            $inputTxn['type'] = "credit";
            $inputTxn['txn_type'] = "bonus";
            $insert =  Transactions::create($inputTxn);

            $checkFirstTxn = Transactions::where("user_id",auth()->user()->id)->first();
            if(empty($checkFirstTxn)){
                $updateUser = User::where("id",auth()->user()->id)->update(["first_invest_amt"=>$bonus_data->amount]);

            }

            return redirect()->back()->with("success", "Plan purchased successfully.");
        }
        return redirect()->back()->with("error", "Failed.");
    }
    
    public function getReceiveIncome(Request $request,$id)
    {

        $current_time = Carbon::now(); // Get the current time

        $start_time = Carbon::today()->setHour(8)->setMinute(0);   // Today at 08:00 AM
        $end_time = Carbon::today()->setHour(23)->setMinute(59);   // Today at 11:59 PM

        if (!$current_time->between($start_time, $end_time)) {
            return redirect()->back()->with("error", "You can complete task between 08:00 AM to 11:59 PM.");
        } 
        
        @$checkFundBalamount = Custom_helper::checkFundBal(auth()->user()->id);
        if ($checkFundBalamount < 60) {
            return redirect()->back()->with("error", "You can complete task due to low fund in your wallet.");
        }


        $task_data = Tasks::where('id',$id)->first();
        $checkUserPlan =  User_plans::where("user_id",auth()->user()->id)->where("status","in-process")->orderBy("created_at","desc")->first();
        
        $txnamt = 0;
        if(!empty($checkUserPlan)){

            if($checkFundBalamount < $checkUserPlan->amount){
                $availablePlans = Plans::where('amount','<',$checkFundBalamount)->orderBy('amount', 'desc')->first();
                $txnamt =  $txnamt + (($availablePlans->amount * 2) / 100);
            }else{
                $txnamt =  $txnamt + (($checkUserPlan->amount * 2) / 100);
            }


            // foreach($checkUserPlan as $key => $item){
            //     $txnamt =  $txnamt + (($item->amount * 2) / 100);
            // }
        }


        $inputReg['user_id'] = auth()->user()->id;
        $inputReg['task_id'] = $id;
        $inputReg['amount'] = @$txnamt;
        $insert =  User_tasks::create($inputReg);

        if ($insert) {
           

            $inputTxn['user_id'] = auth()->user()->id;
            $inputTxn['title'] = $task_data->title;
            $inputTxn['amount'] = @$txnamt;
            $inputTxn['type'] = "credit";
            $inputTxn['txn_type'] = "receive_income";
            $insert =  Transactions::create($inputTxn);

            $checkFirstTxn = Transactions::where("user_id",auth()->user()->id)->first();
            if(empty($checkFirstTxn)){
                $updateUser = User::where("id",auth()->user()->id)->update(["first_invest_amt"=>@$checkUserPlan->amount,"first_invest_amt_plan_id"=>$checkUserPlan->plan_id]);

            }

            $this->distributeBonus(auth()->user()->id, @$txnamt);
            return redirect()->back()->with("success", "Task completed successfully.");
        }
        return redirect()->back()->with("error", "Failed.");
    }

    function distributeBonus($userId, $orderValue)
    {
        $bonusLevels = [
            1 => 20, 
            2 => 10, 
            3 => 5   
        ];

        $referrers = $this->getReferrerHierarchy($userId, 3);
        
        foreach ($bonusLevels as $level => $percentage) {
            if (isset($referrers[$level - 1])) {
                $referrerId = $referrers[$level - 1];
                $bonusAmount = ($orderValue * $percentage) / 100;
                
                $this->storeBonus($referrerId, $bonusAmount);
            }
        }
    }


    function getReferrerHierarchy($userId, $maxLevels)
    {
        $referrers = [];
        $currentUser = $userId;
        
        for ($i = 0; $i < $maxLevels; $i++) {
            $referralCode = DB::table('users')->where('id', $currentUser)->value('referral_by_code');

            if (!$referralCode) {
                break;
            }
    
            // Convert referral code to actual user ID
            $referrerId = DB::table('users')->where('referral_code', $referralCode)->value('id');
    
            if (!$referrerId) {
                break;
            }
    
            $referrers[] = $referrerId;
            $currentUser = $referrerId;
        }
        
        return $referrers;
    }

    function storeBonus($userId, $amount)
    {
        
        @$checkFundBalamount = Custom_helper::checkFundBal($userId);
        if ($checkFundBalamount >= 60) {
            if ($amount > 0) {
                $inputTxn['user_id'] = $userId;
                $inputTxn['title'] = "Team Building Bonus";
                $inputTxn['amount'] = @$amount;
                $inputTxn['type'] = "credit";
                $inputTxn['txn_type'] = "team_building_bonus";
                $insert =  Transactions::create($inputTxn);
            }
        }
    }

    



    public function treeView(Request $request)
    {
        $tree = $this->getReferralHierarchy(auth()->user()->referral_code);
    
        return view('admin.referral_tree', compact('tree'));
        
    }

    
    private function getReferralHierarchy($userId)
    {
        // Fetch direct referrals of the given user
        $users = DB::table('users')
            ->where('referral_by_code', $userId)
            ->get(['id', 'name','referral_code','unique_id']);

        // Convert to an array and add nested referrals
        $tree = [];
        foreach ($users as $user) {
            $tree[] = [
                'id' => $user->id,
                'name' => $user->name,
                'unique_id' => $user->unique_id,
                'children' => $this->getReferralHierarchy($user->referral_code) // Recursive call
            ];
        }

        return $tree; // Multiple referrals are handled in recursion
    }



    public function withdrawalForm(Request $request)
    {
       

        $total_main_wallet =  Transactions::where("user_id",auth()->user()->id)->where("type","credit")->sum('amount');

        $total_debit_amt =  Transactions::where("txn_type","withdrawal")->where("user_id",auth()->user()->id)->where("type","debit")->sum('amount');
        
        $total_main_wallet = $total_main_wallet - $total_debit_amt;
        $total_withdrwal_amt = $total_main_wallet - $total_debit_amt;
        
        $total_user_plans =  User_plans::where("status","in-process")->where("user_id",auth()->user()->id)->sum("amount");
        
        $team_building_bonus =  Transactions::where("user_id",auth()->user()->id)->where("txn_type","team_building_bonus")->where("type","credit")->sum('amount');
        $team_monthly_bonus =  Transactions::where("user_id",auth()->user()->id)->where("txn_type","team_monthly_bonus")->where("type","credit")->sum('amount');
        $total_deposit_bonus =  Transactions::where("user_id",auth()->user()->id)->where("txn_type","deposit_bonus")->where("type","credit")->sum('amount');
        $totalReferIncome =  Transactions::where("user_id",auth()->user()->id)->where("txn_type","bonus")->where("type","credit")->sum('amount');
        $direct_extra_bonus =  Transactions::where("user_id",auth()->user()->id)->where("txn_type","direct_extra_bonus")->where("type","credit")->sum('amount');

        $pending_withdrawal_requests = User_withdrawal_requests::where('status',"pending")->where("user_id",auth()->user()->id)->count();
        $complete_withdrawal_requests = User_withdrawal_requests::where('status',"approved")->where("user_id",auth()->user()->id)->count();
        

        $total_withdrwal_amt = $total_main_wallet + $total_user_plans;
        


        return view('admin.submit-withdrawal-new',compact('total_withdrwal_amt'));
    }

    public function submitWithdrawalRequests(Request $request)
    {
        $checkRequest = User_withdrawal_requests::where('user_id',auth()->user()->id)->where('status',"pending")->first();
        
        if ($checkRequest) {
            return redirect()->back()->with("error", "You have already pending request.");
        }
        
        if ($request->amount < 10) {
            return redirect()->back()->with("error", "Minimum amount $10.");
        }

        $total_main_wallet =  Transactions::where("user_id",auth()->user()->id)->where("type","credit")->sum('amount');
        if ($request->amount > $total_main_wallet) {
            return redirect()->back()->with("error", "Can not be lessthen main wallet.");
        }

        $inputReg['user_id'] =auth()->user()->id;
        $inputReg['status'] = 'pending';
        $inputReg['amount'] = $request->amount;
        $inputReg['email'] = $request->email;
        $inputReg['phone'] = $request->phone;
        $inputReg['bep20_address'] = $request->bep20_address;
        $insert =  User_withdrawal_requests::create($inputReg);

        if ($insert) {
            return redirect()->back()->with("success", "Your request has been submitted kindly wait for 48 to 72 hours.");
        }
        
    }


    
    public function withdrawalRequests(Request $request)
    {
        $data = User_withdrawal_requests::with("userData")->orderBy("created_at","desc")->get();
        return view('admin.withdrawal-requests',compact('data'));
    }

    public function updateWithdrawalRequests(Request $request,$id)
    {
        $reqData = User_withdrawal_requests::where('id',$id)->first();
        if(empty($reqData)){
            return redirect()->back()->with("success", "Data not available.");
        }
        

        $user = User::where('id',$reqData->user_id)->first();

        $inputTxn['user_id'] = $user->id;
        $inputTxn['title'] = "Withdrawal Request";
        $inputTxn['amount'] = $reqData->amount;
        $inputTxn['type'] = "debit";
        $inputTxn['txn_type'] = "withdrawal";
        $insert =  Transactions::create($inputTxn);

        
        $reqData->status = "approved";
        $reqData->save();

        $user->save();
        if ($user) {
            return redirect()->back()->with("success", "Update Successfully.");
        }
    }

    public function createTicket(Request $request)
    {
        return view('admin.create-ticket');
    }

    public function submitTicketReq(Request $request)
    {
        $checkRequest = User_tickets::where('user_id',auth()->user()->id)->where('status',"pending")->first();
        
        if ($checkRequest) {
            return redirect()->back()->with("error", "You have already create a ticket.");
        }

        $inputReg = $request->only('remark','description');
        $inputReg['user_id'] =auth()->user()->id;
        $inputReg['status'] = 'pending';    

        if ($request->upload_file) {
            $upload_fileName = $request->upload_file->store('/images');
            $upload_file = 'uploads/' . $upload_fileName;
            $inputReg['upload_file'] = $upload_file;
        }
        $insert =  User_tickets::create($inputReg);

        if ($insert) {
            return redirect()->back()->with("success", "Your request has been under process wait for 48 to 72 hours.");
        }
        
    }

    public function ticketRequests(Request $request)
    {
        $data = User_tickets::with("userData")->orderBy("created_at","desc")->get();
        return view('admin.user-tickets-requests',compact('data'));
    }

    public function updateTicketRequests(Request $request)
    {
        $checkData = User_tickets::where('id',$request->id)->first();
        if(empty($checkData)){
            return redirect()->back()->with("success", "Data not available.");
        }
        $checkData->reply = $request->reply;
        $checkData->status = "completed";
        $checkData->save();
        if ($checkData) {

            $inputTxn['user_id'] = auth()->user()->id;
            $inputTxn['title'] = "Ticket Feedback : ".@$checkData->remark;
            $inputTxn['description'] = $request->reply;
            $inputTxn['status'] = "0";
            $insert =  User_notifications::create($inputTxn);

            return redirect()->back()->with("success", "Update Successfully.");
        }
    }
    

    public function notificationCreate(Request $request)
    {
        $users = User::where('role_id',"2")->get();
        return view('admin.notification-create',compact('users'));
    }

    public function submitNotification(Request $request)
    {
        $inputTxn['user_id'] = $request->user_id;
        $inputTxn['title'] = $request->title;
        $inputTxn['description'] = $request->description;
        $inputTxn['status'] = "0";
        $insert =  User_notifications::create($inputTxn);

        if ($insert) {
            return redirect()->back()->with("success", "Notification Sent.");
        }
        
    }

    public function addPlanToUser(Request $request)
    {
        $plan_data = Plans::where('id',$request->plan_id)->first();
        $check_user_plan = User_plans::where('user_id',$request->user_id)->where('plan_id',$request->plan_id)->where('status',"in-process")->first();
        
        if(!empty($check_user_plan)){
            return redirect()->back()->with("error", "Plan has already in process.");
        }
        $inputReg['user_id'] = $request->user_id;
        $inputReg['plan_id'] = $request->plan_id;
        $inputReg['amount'] = $plan_data->amount;
        $inputReg['status'] = "in-process";
        $inputReg['admin_status'] = "approved";
        $insert =  User_plans::create($inputReg);

        if ($insert) {

            $inputTxn['user_id'] = $request->user_id;
            $inputTxn['title'] = $plan_data->title;
            $inputTxn['amount'] = $plan_data->amount;
            $inputTxn['type'] = "credit";
            $inputTxn['txn_type'] = "plan";
            $insert =  Transactions::create($inputTxn);
            

            $checkFirstTxn = Transactions::where("user_id",$request->user_id)->first();
            if(empty($checkFirstTxn)){
                $updateUser = User::where("id",$request->user_id)->update(["first_invest_amt"=>$plan_data->amount,"first_invest_amt_plan_id"=>$plan_data->id]);

            }

            return redirect()->back()->with("success", "Plan added successfully.");
        }
        return redirect()->back()->with("error", "Failed.");
    }

    public function updateReadStatus(Request $request,$id)
    {
        $reqData = User_notifications::where('id',$id)->first();
      
        $reqData->status = "1";
        $reqData->save();
        if ($reqData) {
            return redirect()->back();
        }
    }
    public function getThisPlan(Request $request,$id)
    {
        $data = Plans::where('id',$id)->first();
        $check =  User_plans::where("plan_id",$data->id)->where("status","in-process")->where("user_id",auth()->user()->id)->first();
        if(!empty($check)){
            $data->isPurchased = 1;
        }else{
            $data->isPurchased = 0;
        }
        return view('admin.plan-detail',compact('data'));
    }
    public function updateTerminationStatus(Request $request,$userid,$status)
    {
        
        $data = User::where('id',$userid)->first();

        if(!empty($data)){
            
            $data->is_terminate = $status;
            $data->save();
            return redirect()->back()->with("success", "Update successfully.");
        }
        return redirect()->back()->with("error", "Failed.");
    }

    
}
