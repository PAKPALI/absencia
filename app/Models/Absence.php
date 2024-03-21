<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;
    protected $fillable = [
        'students_id',
        'schools_id',
    ];

    public function student(){
        return $this->belongsTo(Student::class,'students_id');
    }
}
