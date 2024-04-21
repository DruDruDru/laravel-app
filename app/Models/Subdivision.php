<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdivision extends Model
{
    use HasFactory;

    public function positions()
    {
        return $this->belongsToMany(
            Position::class,
            "position_subdivision",
            "subdivision_code",
            "position_id"
        );
    }

    protected $fillable = [
        'subdivision_code',
        'name',
        'description'
    ];

    protected $primaryKey = "subdivision_code";
    public $incrementing = false;
    public $timestamps = false;
}
