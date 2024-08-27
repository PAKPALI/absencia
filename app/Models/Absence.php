<?php

namespace App\Models;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absence extends Model
{
    use HasFactory;
    protected $fillable = [
        'classrooms_id',
        'students_id',
        'schools_id',
    ];

    public function classroom(){
        return $this->belongsTo(Classroom::class,'classrooms_id');
    }

    public function student(){
        return $this->belongsTo(Student::class,'students_id');
    }
}
