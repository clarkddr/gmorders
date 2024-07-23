<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('suppliers',SupplierController::class);
Route::resource('galleries',GalleryController::class);
