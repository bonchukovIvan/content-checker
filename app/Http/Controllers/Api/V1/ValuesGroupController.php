<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\Value;

class ValuesGroupController extends Controller
{
    public function store(Request $request) 
    {
        $group = new Group;
        $group->name = $request->name;
        $values_arr = [];
        foreach($request->values as $value) 
        {
            $value = new Value(['search_value' => $value]);
            $values_arr[] = $value;
        }
        $group->save();
        $group->values()->saveMany((array)array_values($values_arr));
        return response()->json($group);
    }

    public function get_all() 
    {
        return response()->json(Group::with('values')->get());
    }

    public function get_one(string $id) 
    {
        return response()->json(Group::findOrFail($id)->load('values'));
    }
    public function update(Request $request, $id) 
    {
        // return response($request);
        $group = Group::findOrFail($id);
        $group->update([
            'name' => $request->name,
        ]);
        foreach($request->values as $key => $value)
        {
            $search_value = $group->values()->findOrFail($key);
            $search_value->update(['search_value' => $value]);
        }
        if(!$request->values_new) 
        {
            return response($group->load('values'));
        }
        $values_arr = [];
        foreach ($request->values_new as $val) 
        {
            $value = new Value(['search_value' => $value]);
            $values_arr[] = $value;
        }
        $group->save();
        $group->values()->saveMany((array)array_values($values_arr));
        return response($group->load('values'));
    }

    public function delete($id) 
    {
        return response(Group::findOrFail($id)->delete());
    }

    public function delete_multiple(Request $request) 
    {     
        foreach ($request->removes as $key => $id) 
        {
            $haystack = Group::findOrFail($id);
            $haystack->delete();
        }
        return response()->json($request);
    }
}
