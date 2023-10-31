<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HaystackController;
use App\Http\Controllers\NeedleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::controller(HaystackController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/view', 'get_all')->name('all');
    Route::get('/view/{id}', 'get_one')->name('view');

    Route::post('/', 'store')->name('store');
    Route::post('/update/{id}', 'update')->name('update');
    Route::post('/remove', 'remove')->name('haystack.remove');

});

Route::controller(NeedleController::class)->group(function () {
    Route::post('needle/remove/{id}', 'remove')->name('needle.remove');
});