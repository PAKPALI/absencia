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
        'professor',
        'schools_id',
    ];

    public function user(){
        return  $this ->belongsTo(User::class,'manager');
    }
    public function professors(){
        return  $this ->belongsTo(User::class,'professor');
    }
    public function school(){
        return  $this ->belongsTo(School::class,'schools_id');
    }
}
