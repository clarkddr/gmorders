<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/plan', [ImageController::class,'plan'])->name('plan');


Route::resource('suppliers',SupplierController::class);
Route::resource('galleries',GalleryController::class);
Route::get('/select', [GalleryController::class,'select'])->name('select');
Route::resource('images',ImageController::class);




Route::get('/upload', function () {
    return view('upload');
});
Route::post('/upload', [GalleryController::class, 'upload'])->name('upload');


Route::get()
