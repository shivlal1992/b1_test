<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Exam_allocations extends Model
{
    protected $guarded = [];
   
  
   
    public function userData()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
   
    public function examCenterData()
    {
        return $this->hasOne(Exam_centers::class, 'id', 'center_id');
    }
   
    public function examData()
    {
        return $this->hasOne(Exams::class, 'id', 'exam_id');
    }
   
    public function examResultData()
    {
        return $this->hasOne(Exam_results::class, 'unique_id', 'unique_id')->latest();
    }
   
}
