<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'manager',
        'professors',
        'schools_id',
    ];

    public function user(){
        return  $this ->belongsTo(User::class,'manager');
    }
    public function school(){
        return  $this ->belongsTo(School::class,'schools_id');
    }
}
