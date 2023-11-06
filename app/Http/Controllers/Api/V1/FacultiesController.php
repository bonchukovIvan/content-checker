<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultiesController extends Controller
{
    public function get_all() 
    {
        return response()->json(Faculty::with('sites')->get());
    }

    public function get_one(string $id) 
    {
        return response()->json(Faculty::findOrFail($id)->with('sites')->get());
    }
}