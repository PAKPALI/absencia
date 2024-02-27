<?php

namespace App\Models;

use App\Models\Pays;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pays_id',
        'first_name',
        'last_name',
        'email',
        'num1',
        'num2',
        'gender',
        'school_id',
        'password',
        'user_type',
        'connected',
    ];


    public function country(){
        return  $this ->belongsTo(Pays::class,'pays_id');
    }
    public function school(){
        return  $this ->belongsTo(School::class,'school_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
