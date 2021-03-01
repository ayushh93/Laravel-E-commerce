<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin' ;

    protected $fillable = [
        'name', 'email', 'password','image','address','status','phone','role_id','created_at','updated_at'
    ];

    protected $hidden = [
        'password'
    ];

}
