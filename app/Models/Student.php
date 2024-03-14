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
    ];

    public function fullName(){
        return  strtoupper($this ->last_name).' '.$this ->first_name;
    }
}
