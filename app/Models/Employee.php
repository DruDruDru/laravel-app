<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'firstname', 'lastname', 'patronymic',
        'birth_date', 'hire_date', 'termination_date',
        'gender', 'login', 'salary',
    ];

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    public $timestamps = false;
}
