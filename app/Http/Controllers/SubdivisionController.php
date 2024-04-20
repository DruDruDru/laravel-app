<?php

namespace App\Http\Controllers;

use App\Models\Subdivision;
use Illuminate\Http\Request;

class SubdivisionController extends Controller
{
    public function list()
    {
        return Subdivision::with("positions")->get();
    }
}
