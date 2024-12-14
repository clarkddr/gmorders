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
    $day = Carbon::today();
    $today = $day->copy()->format('Y-m-d'); // Fecha de hoy

    $lastYear = $day->copy()
        ->subYear() // Ir al mismo día del año pasado
        ->next($day->copy()->format('l')) // Ajustar al mismo día de la semana
        ->format('Y-m-d');
//    $today = '2024-11-26';
//    $lastYear = '2023-11-28';

    $hourNow = (int) Carbon::now()->format('H');
//    $hourNow = 23;

    $queryLastyear = "EXEC dbo.DRSalesByHour @From = '{$lastYear}', @To = '{$lastYear}'";
    $lastyearResults = DB::connection('mssql')->selectResultSets($queryLastyear);
    $lastyearResults = collect($lastyearResults[0]);

    $queryToday = "EXEC dbo.DRSalesByHour @From = '{$today}' , @To = '{$today}'";
    $todayResults = DB::connection('mssql')->selectResultSets($queryToday);
    $todayResults = collect($todayResults[0]);

    $todayAccumulated = 0; $lastYearAccumulated = 0;
    $amounts = $lastyearResults->map(function ($hour) use ($hourNow, &$todayAccumulated, &$lastYearAccumulated, $todayResults) {
        $amount = $hour->Amount;
        $todaySale = $todayResults->where('Hour', $hour->Hour)->first()->Amount ?? 0;
        $lastYearAccumulated += $amount;
        $todayAccumulated += $todaySale;
        $relation = $todayAccumulated / $lastYearAccumulated * 100 ?? 0;
        $hour = (int) $hour->Hour;
        if($hour > $hourNow) {
            return collect([
                'hour' => $hour,
                'lastYear' => null,
                'today' => null,
                'lastYearAccumulated' => null,
                'todayAccumulated' => null,
                'relation' => null,
            ]);
        }

       return collect([
           'hour' => $hour,
           'lastYear' => number_format($amount,0),
           'today' => number_format($todaySale,0),
           'lastYearAccumulated' => number_format($lastYearAccumulated,0),
           'todayAccumulated' => number_format($todayAccumulated,0),
           'relation' =>$relation,
       ]);
    })->filter();
    $data = [
        'amounts' => $amounts,
    ];

    return view('chartHour', $data);




});

Route::get('/hourData', function () {
    $day = Carbon::today();
    $today = $day->copy()->format('Y-m-d'); // Fecha de hoy

    $lastYear = $day->copy()
        ->subYear() // Ir al mismo día del año pasado
        ->next($day->copy()->format('l')) // Ajustar al mismo día de la semana
        ->format('Y-m-d');
//    $today = '2024-11-26';
//    $lastYear = '2023-11-28';

    $hourNow = (int) Carbon::now()->format('H');
//    $hourNow = 23;

    $queryLastyear = "EXEC dbo.DRSalesByHour @From = '{$lastYear}', @To = '{$lastYear}'";
    $lastyearResults = DB::connection('mssql')->selectResultSets($queryLastyear);
    $lastyearResults = collect($lastyearResults[0]);

    $queryToday = "EXEC dbo.DRSalesByHour @From = '{$today}' , @To = '{$today}'";
    $todayResults = DB::connection('mssql')->selectResultSets($queryToday);
    $todayResults = collect($todayResults[0]);

    $todayAccumulated = 0; $lastYearAccumulated = 0;
    $amounts = $lastyearResults->map(function ($hour) use ($hourNow, &$todayAccumulated, &$lastYearAccumulated, $todayResults) {
        $amount = $hour->Amount;
        $todaySale = $todayResults->where('Hour', $hour->Hour)->first()->Amount ?? 0;
        $lastYearAccumulated += $amount;
        $todayAccumulated += $todaySale;
        $relation = $todayAccumulated / $lastYearAccumulated * 100 ?? 0;
        $hour = (int) $hour->Hour;
        if($hour > $hourNow) {
            return collect([
                'hour' => $hour,
                'lastYear' => null,
                'today' => null,
                'lastYearAccumulated' => null,
                'todayAccumulated' => null,
                'relation' => null,
            ]);
        }


       return [
           'hour' => $hour,
           'lastYear' => number_format($amount,0),
           'today' => number_format($todaySale,0),
           'lastYearAccumulated' => number_format($lastYearAccumulated,0),
           'todayAccumulated' => number_format($todayAccumulated,0),
           'relation' =>$relation,
       ];
    })->OrderBy('hour');


    return response()->json($amounts);




});
