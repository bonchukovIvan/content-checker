<?php

use App\Http\Controllers\Api\V1\FacultiesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SitesController;
use App\Http\Controllers\Api\V1\LinksController;

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
        Sites controller
     */
    Route::get('sites', [SitesController::class, 'get_all'])->name('sites');
    Route::get('sites/{id}', [SitesController::class, 'get_one']);

    Route::post('sites', [SitesController::class, 'store'])->name('sites.store');
    Route::delete('sites', [SitesController::class, 'delete_multiple'])->name('sites.delete_multiple');
    /*
        Links controller
     */
    Route::get('links', [LinksController::class, 'get_all']);
    Route::get('links/{id}', [LinksController::class, 'get_one']);

    Route::post('links', [LinksController::class, 'store']);
    Route::patch('links/{id}', [LinksController::class, 'update']);
    Route::delete('links/{id}', [LinksController::class, 'delete']);
    /*
        Faculty controller
     */
    Route::get('faculties', [FacultiesController::class, 'get_all'])->name('faculties');
    Route::get('faculties/{id}', [FacultiesController::class, 'get_one']);
});