<?php


namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Transactions;
use App\Models\User_plans;
use Carbon\Carbon;

class Custom_helper
{
    public static function checkFundBal($userid) {

        $get_user_plans =  User_plans::where("status","in-process")->where("user_id",$userid)->orderBy('created_at',"desc")->first();
        $total_user_plans =  $get_user_plans ? $get_user_plans->amount : 0;

        $total_debit_amt =  Transactions::where("txn_type","withdrawal")->where("user_id",auth()->user()->id)->where("type","debit")->sum('amount');
        $total_deposit_bonus =  Transactions::where("user_id",$userid)->where("txn_type","deposit_bonus")->where("type","credit")->sum('amount');
        $totalReferIncome =  Transactions::where("user_id",$userid)->where("txn_type","bonus")->where("type","credit")->sum('amount');
        $team_building_bonus =  Transactions::where("user_id",$userid)->where("txn_type","team_building_bonus")->where("type","credit")->sum('amount');
        $team_monthly_bonus =  Transactions::where("user_id",$userid)->where("txn_type","team_monthly_bonus")->where("type","credit")->sum('amount');
        $direct_extra_bonus =  Transactions::where("user_id",$userid)->where("txn_type","direct_extra_bonus")->where("type","credit")->sum('amount');
        
        
        $total_receive_income =  Transactions::where("user_id",$userid)->where("txn_type","receive_income")->where("type","credit")->sum('amount');
        
        
        $wallet_bal = $total_receive_income + $total_deposit_bonus + $totalReferIncome + $team_building_bonus + $team_monthly_bonus + $direct_extra_bonus;
        
        $fundBal = $wallet_bal + $total_user_plans - $total_debit_amt;

        // return $fundBal;
        return $fundBal;
    }
    
   
}
