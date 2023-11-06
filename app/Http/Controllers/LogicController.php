<?php

namespace App\Http\Controllers;

use App\Models\Haystack;
use Illuminate\Http\Request;


class LogicController extends Controller
{
    public function main() 
    {
        $haystacks = Haystack::with('needles')->get();
        $result = [];
        $test = [];
        foreach($haystacks as $haystack) 
        {
            $content = file_get_contents($haystack->link);
            foreach ($haystack->needles as $key => $needles) 
            {
                $chunk['name'] = $haystack->name; 
                $chunk['link'] = $haystack->link;
                $chunk['needles'][$needles->value] = str_contains(mb_strtolower($content), trim(mb_strtolower($needles->value))); 
                $test[] = mb_strtolower($needles->value);
            }
            array_push($result, $chunk);
            $chunk = [];
        }
        
        return response(['result' => (array)$result, 'test' => $test]);
    }

    public function result() {
        return view('logic.result');
    }

    public function check() {
        return view('logic.check');
    }
}
