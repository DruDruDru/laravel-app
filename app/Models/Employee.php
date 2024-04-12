<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname', 'lastname', 'patronymic',
        'birth_date', 'hire_date', 'termination_date',
        'gender', 'login', 'salary',
    ];

    public $timestamps = false;
}
