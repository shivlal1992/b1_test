<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Exam_results extends Model
{
    protected $guarded = [];

   
    public function examAllocationData()
    {
        return $this->hasOne(Exam_allocations::class, 'id', 'unique_id');
    }
   
}
