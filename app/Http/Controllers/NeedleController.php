<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Needle;

class NeedleController extends Controller
{
    public function remove(Request $request) {
        if (!$request->remove_needles) {
            return response(['succcess' => false]);
        }

        foreach($request->remove_needles as $key => $id) {
            $needle = Needle::findOrFail($id);
            $needle->delete();
        }
        return response($needle);
    }
}
// const values = document.getElementById('values');
//                     values.innerHTML = '';
//                     get_one();