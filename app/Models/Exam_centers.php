<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Exam_centers extends Model
{
    protected $guarded = [];
    protected $fillable = [
   'location','lat','long','facilities','capacity_seat',
   'logistics','district_id','created_by',
   'slot','start_time','end_time'
];

   
    public function createdByData()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    public function districtData()
    {
        return $this->hasOne(Districts::class, 'id', 'district_id');
    }
}
