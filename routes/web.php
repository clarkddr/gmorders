<?php

use App\Http\Controllers\FamilySalesOverYearsController;
use App\Http\Controllers\PurchaseOverSaleController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SaleandPurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProjectionAmountController;
use App\Http\Controllers\ProjectionController;
use App\Http\Controllers\SessionController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function(){
    // Route::get('/register', [RegisteredUserController::class,'create']);
    // Route::post('/register', [RegisteredUserController::class,'store']);
    Route::get('/login', [SessionController::class,'create'])->name('login');
    Route::post('/login', [SessionController::class,'store']);
});

Route::middleware('auth')->group(function(){
    Route::get('/',function(){  return view('home');  });
    Route::get('/salesyearoy',[FamilySalesOverYearsController::class,'index'])->name('salesyearoy.index');
    Route::get('/saleandpurchase',[SaleAndPurchaseController::class,'index'])->name('saleandpurchase.index');
    Route::get('/projections/amounts', [ProjectionController::class, 'amounts']);
    Route::resource('projections',ProjectionController::class);
    Route::resource('projectionamount',ProjectionAmountController::class);
    Route::get('purchaseoversale',[PurchaseOverSaleController::class,'index'])->name('purchaseoversale.index');
    Route::get('purchaseoversale/{id}',[PurchaseOverSaleController::class,'show'])->name('purchaseoversale.show');
});

Route::get('/plan', [ImageController::class,'plan'])->name('plan');

Route::resource('suppliers',SupplierController::class);
Route::resource('galleries',GalleryController::class);
Route::resource('images',ImageController::class);

Route::get('test', function () {
    return view();
});



Route::get('/upload', function () {
    return view('upload');
});

Route::post('/upload', [GalleryController::class, 'upload'])->name('upload');

Route::delete('/logout', [SessionController::class,'destroy'])->middleware('auth');


Route::get('/php', function () {
    $sql = DB::connection('mssql')->select('select * from branch');
    return phpinfo();
});

Route::get('/sql', function () {
    $sql = DB::connection('mssql')->select('select * from branch');
    dd($sql);
});

Route::get('/chart', function () {
    return view('chart');
});


Route::get('/dates', function () {


});

Route::get('/hour', function () {
    $today = Carbon::today()->format('Y-m-d');
    $lastYear = Carbon::today()->subYear()->format('Y-m-d');

    $queryLastyear = "EXEC dbo.DRSalesByHour @From = '{$lastYear}', @To = '{$lastYear}'";
    $lastyearResults = DB::connection('mssql')->selectResultSets($queryLastyear);
    $lastyearResults = collect($lastyearResults[0]);

    $queryToday = "EXEC dbo.DRSalesByHour @From = '{$today}' , @To = '{$today}'";
    $todayResults = DB::connection('mssql')->selectResultSets($queryToday);
    $todayResults = collect($todayResults[0]);

    $todayAccumulated = 0; $lastYearAccumulated = 0;
    $amounts = $lastyearResults->map(function ($hour) use (&$todayAccumulated, &$lastYearAccumulated, $todayResults) {
        $amount = $hour->Amount;
        $todaySale = $todayResults->where('Hour', $hour->Hour)->first()->Amount ?? 0;
        $lastYearAccumulated += $amount;
        $todayAccumulated += $todaySale;
        $relation = $todayAccumulated / $lastYearAccumulated ?? 0;

       return collect([
           'hour' => $hour->Hour,
           'lastYear' => $amount,
           'today' => $todaySale,
           'lastYearAccumulated' => $lastYearAccumulated,
           'todayAccumulated' => $todayAccumulated,
           'relation' => $relation,
       ]);
    });

    dd($amounts);




});
