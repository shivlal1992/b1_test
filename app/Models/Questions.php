<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Questions extends Model
{
    protected $guarded = [];
   
    public function subjectData()
    {
        return $this->hasOne(Test_subjects::class, 'id', 'subject_id');
    }
}
