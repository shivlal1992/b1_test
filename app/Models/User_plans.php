<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_plans extends Model
{
    protected $guarded = [];
    
    public function userData()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function planData()
    {
        return $this->hasOne(Plans::class, 'id', 'plan_id');
    }
}
