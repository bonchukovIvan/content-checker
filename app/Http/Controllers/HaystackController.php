<?php

namespace App\Http\Controllers;

use App\Models\Haystack;
use App\Models\Needle;
use Illuminate\Http\Request;

class HaystackController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function get_all()
    {
        $haystacks = Haystack::with('needles')->get();
        return view('view', ['haystacks' => $haystacks]);
    }

    public function get_one(string $id)
    {
        $haystack = Haystack::findOrFail($id);
        $haystack->load('needles');
        return view('haystack', ['haystack' => $haystack]);
    }

    public function update(Request $request, $id) 
    {
        $haystack = Haystack::findOrFail($id);
        $haystack->update([
            'name' => $request->name,
            'link' => $request->link
        ]);

        if ($request->needles_new) 
        {
            $needles = [];
            foreach ($request->needles_new as $key => $value) 
            {
                $needle = new Needle(['value' => $value]);
                array_push($needles, $needle);
            }
            $haystack->needles()->saveMany((array)array_values($needles));
        }
        
        if ($request->needles) {
            foreach ($request->needles as $needle_id => $value) 
            {
                $needle = $haystack->needles()->findOrFail($needle_id);
                $needle->update($value);
            }
        }

        return redirect()->route('view', $id)->with('success', 'Update successfully.');
    }

    public function store(Request $request)
    {
        $haystack = new Haystack;

        $haystack->name = $request->name;
        $haystack->link = $request->link;
        
        $needles = [];
        foreach ($request->values as $key => $value) 
        {
            $needle = new Needle(['value' => $value]);
            array_push($needles, $needle);
        }

        $haystack->save();
        $haystack->needles()->saveMany((array)array_values($needles));
        
        return response(['success' => $request->values]);
    }

    public function remove(Request $request) {
        if (!$request->remove_heystacks) {
            return redirect()->route('all')->with('success', 'Haystack not selected.');
        }
        foreach ($request->remove_heystacks as $key => $id) {
            $haystack = Haystack::findOrFail($id);
            $haystack->delete();
        }
        return redirect()->route('all')->with('success', 'User deleted successfully.');
    }
}
