<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User_plans;
use App\Models\Transactions;
use Carbon\Carbon;

class DailyIncome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyincome:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $getUserPlans = User_plans::where('status',"in-process")->get();
        $dailyIncome = 0;
        foreach ($getUserPlans as $key => $value) {
            $check =  Transactions::where('txn_type_id', $value->plan_id)->whereDate('created_at', Carbon::today())->first();
            if(empty($check)){
                $inputTxn['user_id'] = $value->user_id;
                $inputTxn['title'] = "Daily Income";
                $inputTxn['amount'] = ($value->amount*2)/100;
                $inputTxn['type'] = "credit";
                $inputTxn['txn_type'] = "daily_income";
                $inputTxn['txn_type_id'] = $value->plan_id;
                $insert =  Transactions::create($inputTxn);
            }
        }
        return 1;
    }
}
