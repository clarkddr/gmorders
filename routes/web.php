<?php

use App\Http\Controllers\FamilySalesOverYearsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProjectionController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function(){
    // Route::get('/register', [RegisteredUserController::class,'create']);
    // Route::post('/register', [RegisteredUserController::class,'store']);
    Route::get('/login', [SessionController::class,'create'])->name('login');
    Route::post('/login', [SessionController::class,'store']);
});

Route::middleware('auth')->group(function(){
    Route::get('/',function(){
        return view('welcome');
    });
    Route::get('/salesyearoy',[FamilySalesOverYearsController::class,'index'])->name('salesyearoy');
    Route::get('/getsalesyearoy',[FamilySalesOverYearsController::class,'show'])->name('salesyearoy.show');
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

Route::delete('/logout', [SessionController::class,'destroy'])->middleware('auth');
