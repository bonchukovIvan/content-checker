<?php

use App\Http\Controllers\Client\LogicController;
use App\Http\Controllers\Client\SiteController;
use App\Http\Controllers\Client\ValuesGroupController;
use Illuminate\Support\Facades\Route;

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
// Route::controller(HaystackController::class)->group(function () {
//     Route::get('/', 'index');
//     Route::get('/view', 'get_all')->name('all');
//     Route::get('/view/{id}', 'view_one')->name('view');
//     Route::get('/get/{id}', 'get_one')->name('haystack.get_one');

//     Route::post('/', 'store')->name('store');
//     Route::post('/update/{id}', 'update')->name('update');
//     Route::post('/remove', 'remove')->name('haystack.remove');
// });

// Route::controller(NeedleController::class)->group(function () {
//     Route::post('needle/remove', 'remove')->name('needle.remove');
// });

// Route::controller(LogicController::class)->group(function () {
//     Route::get('/logic/check', 'check')->name('logic.check');
//     Route::get('/logic/result', 'result')->name('logic.result');
//     Route::post('/logic/main', 'main')->name('logic.main');
// });

// v2 -----------------------------------------------------------------

Route::controller(SiteController::class)->group(function () {
    Route::get('/sites', 'index');
    Route::get('/sites/{id}', 'get_one');
});
Route::controller(ValuesGroupController::class)->group(function () {
    Route::get('values', 'index');
    Route::get('/values/{id}', 'get_one');
});
Route::controller(LogicController::class)->group(function () {
    Route::get('/', 'index');
});