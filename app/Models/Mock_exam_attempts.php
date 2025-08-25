<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Mock_exam_attempts extends Model
{
    protected $guarded = [];
   
    public function questionData()
    {
        return $this->hasOne(Questions::class, 'id', 'question_id');
    }
   
}
