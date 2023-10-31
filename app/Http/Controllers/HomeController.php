<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\Flight;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
 
class HomeController extends Controller
{
    /**
     * Store a new flight in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request...
 
        $flight = new Flight;
 
        $flight->name = $request->name;
 
        $flight->save();
 
        return redirect('/flights');
    }
}