<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = [
        'pays_id',
        'users_id',
        'name',
        'email',
        'numero',
        'connected',
    ];

    public function country(){
        return  $this ->belongsTo(Pays::class,'pays_id');
    }

    public function user(){
        return  $this ->belongsTo(User::class,'users_id');
    }
}
