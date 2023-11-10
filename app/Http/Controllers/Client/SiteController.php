<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index() 
    {
        return view('client.sites.index');
    }

    public function get_one(string $id) 
    {
        return view('client.sites.site', ['id' => $id]);
    }
}