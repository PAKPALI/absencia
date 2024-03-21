<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'classrooms_id',
        'first_name',
        'last_name',
        'email',
        'email2',
        'num1',
        'num2',
        'gender',
        'absence',
    ];

    public function fullName(){
        return  strtoupper($this ->last_name).' '.$this ->first_name;
    }

    public function classroom(){
        return $this->belongsTo(Classroom::class,'classrooms_id');
    }

    public function absence(){
        return  $this ->hasMany(Absence::class);
    }
}
