<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Departament;
use Illuminate\Http\Request;

class DepartamentController extends Controller
{
    public function get_all() 
    {
        return response()->json(Departament::all());
    }

    public function get_one(string $id) 
    {
        return response()->json(Departament::findOrFail($id)->get());
    }
}
