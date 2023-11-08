<?php

use App\Http\Controllers\Api\V1\FacultiesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SitesController;
use App\Http\Controllers\Api\V1\LinksController;
use App\Http\Controllers\Api\V1\ValuesGroupController;
use App\Http\Controllers\Api\V1\LogicController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(array('prefix' => '/v1'), function()
{
    /*
        Site controller
     */
    Route::get('sites', [SitesController::class, 'get_all'])->name('sites');
    Route::get('sites/{id}', [SitesController::class, 'get_one'])->name('sites.get_one');

    Route::post('sites', [SitesController::class, 'store'])->name('sites.store');
    Route::patch('sites/{id}', [SitesController::class, 'update'])->name('sites.update');
    Route::delete('sites', [SitesController::class, 'delete_multiple'])->name('sites.delete_multiple');
    /*
        Faculty controller
     */
    Route::get('faculties', [FacultiesController::class, 'get_all'])->name('faculties');
    Route::get('faculties/{id}', [FacultiesController::class, 'get_one']);
    /*
        ValuesGroup controller
     */
    Route::get('values-group', [ValuesGroupController::class, 'get_all'])->name('values-group');
    Route::get('values-group/{id}', [ValuesGroupController::class, 'get_one'])->name('values-group.get_one');

    Route::post('values-group', [ValuesGroupController::class, 'store'])->name('values-group.store');
    Route::patch('values-group/{id}', [ValuesGroupController::class, 'update'])->name('values-group.update');
    Route::delete('values-group', [ValuesGroupController::class, 'delete_multiple'])->name('values-group.delete_multiple');
     /*
        Logic controller
     */
    Route::get('logic', [LogicController::class, 'index'])->name('logic');
});