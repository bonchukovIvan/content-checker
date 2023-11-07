<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function store(Request $request) 
    {
        $link = new Link;
        $link->sites_link = $request->sites_link;
        $link->faculty_id = $request->faculty_id;
        $link->save();
        return response()->json($link);
    }

    public function get_all() 
    {
        return response()->json(Link::with('faculty')->get());
    }

    public function get_one(string $id) 
    {
        return response()->json(Link::findOrFail($id)->load('faculty'));
    }

    public function update(Request $request, $id) 
    {
        $link = Link::findOrFail($id);
        $link->update([
            'sites_link' => $request->sites_link,
            'faculty_id' => $request->faculty_id,
        ]);
        return response($link->load('faculty'));
    }

    public function delete($id) 
    {
        return response(Link::findOrFail($id)->delete());
    }

    public function delete_multiple(Request $request) 
    {     
        foreach ($request->removes as $key => $id) 
        {
            $haystack = Link::findOrFail($id);
            $haystack->delete();
        }
        return response()->json(Link::with('faculty'));
    }
}