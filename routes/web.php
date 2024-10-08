<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ImageController;
<<<<<<< HEAD
use App\Http\Controllers\ProjectionController;
use Illuminate\Support\Facades\DB;
=======
>>>>>>> parent of adea7bf (Se guardan cambios antes de integrar Proyeccion y DB Branix)
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/plan', [ImageController::class,'plan'])->name('plan');
Route::get('/select', [GalleryController::class,'select'])->name('select');

Route::resource('suppliers',SupplierController::class);
Route::resource('galleries',GalleryController::class);
Route::resource('images',ImageController::class);
Route::resource('projection',ProjectionController::class);





Route::get('/upload', function () {
    return view('upload');
});

Route::post('/upload', [GalleryController::class, 'upload'])->name('upload');
<<<<<<< HEAD

=======
>>>>>>> parent of adea7bf (Se guardan cambios antes de integrar Proyeccion y DB Branix)
