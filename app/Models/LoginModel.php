<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model
{
    protected $table = 'users'; // Assuming your users table is named 'users'

    protected $fillable = [
        'email',
        'password',
    ];
    
}
