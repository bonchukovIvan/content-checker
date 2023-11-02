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
        return response($haystacks);
    }

    public function view_one(string $id)
    {
        return view('haystack', ['id' => $id]);
    }

    public function get_one(string $id)
    {
        $haystack = Haystack::findOrFail($id);
        $haystack->load('needles');
        return response($haystack);;
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

        return response($haystack);
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
        
        return redirect()->route('all');
    }

    public function remove(Request $request) {
        if (!$request->remove_haystacks) {
            return redirect()->route('all');
        }
        foreach ($request->remove_haystacks as $key => $id) {
            $haystack = Haystack::findOrFail($id);
            $haystack->delete();
        }
        return redirect()->route('all');
    }
}
