<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilySalesOverYearsController;
use App\Http\Controllers\PurchaseOverSaleController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SaleandPurchaseController;
use App\Http\Controllers\StylesResultsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProjectionAmountController;
use App\Http\Controllers\ProjectionController;
use App\Http\Controllers\ProjectionMonthController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchSalesTargetController;
use App\Http\Controllers\YearSalesController;
use App\Http\Controllers\PerformanceController;

Route::middleware('guest')->group(function(){
    // Route::get('/register', [RegisteredUserController::class,'create']);
    // Route::post('/register', [RegisteredUserController::class,'store']);
    Route::get('/login', [SessionController::class,'create'])->name('login');
    Route::post('/login', [SessionController::class,'store']);
});

Route::middleware('auth')->group(function(){
//    Route::get('/',function(){  return view('home');  });
    Route::get('/',[DashboardController::class,'index'])->name('dashboard.index');
    Route::get('/salesyearoy',[FamilySalesOverYearsController::class,'index'])->name('salesyearoy.index');
    Route::get('/saleandpurchase',[SaleAndPurchaseController::class,'index'])->name('saleandpurchase.index');
    Route::get('/projections/amounts', [ProjectionController::class, 'amounts']);
    Route::resource('projections',ProjectionController::class);
    Route::get('projectionamount/branches',[ProjectionAmountController::class,'branches'])->name('projectionamount.branches');
    Route::resource('projectionamount',ProjectionAmountController::class);
    Route::get('purchaseoversale',[PurchaseOverSaleController::class,'index'])->name('purchaseoversale.index');
    Route::get('purchaseoversale/{id}',[PurchaseOverSaleController::class,'show'])->name('purchaseoversale.show');
    Route::get('branches',[BranchSalesTargetController::class,'index'])->name('branchTarget.index');
    Route::get('projectionmonth/{id}',[ProjectionMonthController::class,'index'])->name('projectionmonth.index');
    Route::post('projectionmonth',[ProjectionMonthController::class,'store'])->name('projectionmonth.store');
    Route::get('yearsales',[YearSalesController::class,'index'])->name('yearsales.index');
    Route::get('performance',[PerformanceController::class,'index'])->name('performance.index');
    Route::get('stylesresults',[StylesResultsController::class,'index'])->name('stylesresults.index');
});

Route::get('branch/{uid}',[BranchSalesTargetController::class,'show'])->name('branchTarget.show');

Route::get('/plan', [ImageController::class,'plan'])->name('plan');

Route::resource('suppliers',SupplierController::class);
Route::resource('galleries',GalleryController::class);
Route::resource('images',ImageController::class);

Route::get('/upload', function () {
    return view('upload');
});

Route::post('/upload', [GalleryController::class, 'upload'])->name('upload');
Route::delete('/logout', [SessionController::class,'destroy'])->middleware('auth');
Route::get('/php', function () {
    $sql = DB::connection('mssql')->select('select * from branch');
    return phpinfo();
});

Route::get('/chart', function () {
    return view('chart');
});


