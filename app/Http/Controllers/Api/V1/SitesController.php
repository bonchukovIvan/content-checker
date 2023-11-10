<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;

class SitesController extends Controller
{
    public function store(Request $request) 
    {
        $site = new Site;
        $site->link = $request->link;
        $site->faculty_id = $request->faculty_id;
        $site->save();
        return response()->json($request);
    }

    public function get_all() 
    {
        return response()->json(Site::with('faculty')->get());
    }

    public function get_one(string $id) 
    {
        return response()->json(Site::findOrFail($id)->load('faculty'));
    }
    public function update(Request $request, $id) 
    {
        $site = Site::findOrFail($id);
        $site->update([
            'sites_link' => $request->sites_link,
            'faculty_id' => $request->faculty_id,
        ]);
        return response($site);
    }

    public function delete($id) 
    {
        return response(Site::findOrFail($id)->delete());
    }

    public function delete_multiple(Request $request) 
    {     
        foreach ($request->removes as $key => $id) 
        {
            $haystack = Site::findOrFail($id);
            $haystack->delete();
        }
        return response()->json($request);
    }
}
