<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes,HasRoles;
    protected $guarded = [];

    
    public function roleData()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }
   
    public function userPlans()
    {
        return $this->hasOne(User_plans::class, 'user_id', 'id');
    }
    public function districtData()
    {
        return $this->hasOne(Districts::class, 'id', 'district_id');
    }
    public function examCenterData()
    {
        return $this->hasOne(Exam_centers::class, 'id', 'exam_center_id');
    }

    public function examAllocations()
    {
        return $this->hasMany(Exam_allocations::class, 'user_id');
    }

    public function createdByData()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
   

}
