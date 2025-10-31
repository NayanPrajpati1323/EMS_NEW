<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class RegisterEmployeesModel extends Authenticatable
{
    use HasFactory;
    use Notifiable;


    protected $table = 'register_users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = ['password', 'remember_token'];
}
