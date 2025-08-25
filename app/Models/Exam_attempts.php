<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Exam_attempts extends Model
{
    protected $guarded = [];
   
    public function questionData()
    {
        return $this->hasOne(Questions::class, 'id', 'question_id');
    }
   
    public function examAllocationData()
    {
        return $this->hasOne(Exam_allocations::class, 'id', 'unique_id');
    }
   
}
