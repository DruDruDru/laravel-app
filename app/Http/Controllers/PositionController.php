<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function list()
    {
        return Position::with("subdivisions")->get();
    }
}
