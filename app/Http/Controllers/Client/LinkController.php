<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index() 
    {
        return view('client.links.index');
    }

    public function get_one(string $id) 
    {
        return view('client.links.site', ['id' => $id]);
    }
}
