<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Tasks extends Model
{
    protected $guarded = [];

    public static function getDailyTask()
    {
        $today = Carbon::today();
       

        $task = self::whereDate('last_displayed_at', $today)->first();
        if ($task) {
          
            return $task;
        }

        $newTask = self::whereNull('last_displayed_at')
            ->orWhere('last_displayed_at', '<', $today)
            ->inRandomOrder()
            ->first();

        if ($newTask) {
            
            $newTask->update(['last_displayed_at' => $today]);
            $userdata = User::where('id',auth()->user()->id)->first();
            $userdata->total_task_assgined = $userdata->total_task_assgined + 1;
            $userdata->save();
           
        }

        return $newTask;
    }
}
