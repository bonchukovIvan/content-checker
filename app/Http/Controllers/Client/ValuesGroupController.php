<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValuesGroupController extends Controller
{
    public function index() 
    {
        return view('client.values.index');
    }

    public function get_one(string $id) 
    {
        return view('client.values.value', ['id' => $id]);
    }
}