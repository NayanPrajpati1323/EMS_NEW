<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeesModel extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'gender',
        'image',
        'status',
    ];
    
}
