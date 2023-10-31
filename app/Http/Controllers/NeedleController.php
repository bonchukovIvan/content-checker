<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Needle;

class NeedleController extends Controller
{
    public function remove(Request $request, $haystack_id) {
        if (!$request->remove_needles) {
            return redirect()->route('view', $haystack_id)->with('success', 'Needle not selected.');
        }

        foreach($request->remove_needles as $key => $id) {
            $haystack = Needle::findOrFail($id);
            $haystack->delete();
        }
        return redirect()->route('view', $haystack_id)->with('success', 'Needle deleted successfully.');
    }
}
