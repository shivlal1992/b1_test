<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Mock_exam_results extends Model
{
    protected $guarded = [];

   public function userData()
    {
        return $this->hasOne(User::class, 'id', 'unique_id');
    }
     public function examData()
    {
        return $this->hasOne(Exams::class, 'id', 'exam_id');
    }
   
}
