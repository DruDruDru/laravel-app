<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    public function subdivisions()
    {
        return $this->belongsToMany(Subdivision::class);
    }

    protected $fillable = [
        'name',
        'description'
    ];

    public $timestamps = false;
}