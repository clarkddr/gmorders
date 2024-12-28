<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $day = Carbon::today();
        $today = $day->copy()->format('Y-m-d'); // Fecha de hoy

        $lastYear = $day->copy()
            ->subYear() // Ir al mismo día del año pasado
//        ->next($day->copy()->format('l')) // Ajustar al mismo día de la semana
            ->format('Y-m-d');
        $todayFormatted = Carbon::parse($today)->isoFormat('dddd D [de] MMMM YYYY');
        $lastYearFormatted = Carbon::parse($lastYear)->isoFormat('dddd D [de] MMMM YYYY');
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
                    'hour' => $hour+1,
                    'lastYear' => $amount,
                    'today' => $todaySale,
                    'lastYearAccumulated' => null,
                    'todayAccumulated' => null,
                    'relation' => null,
                ]);
            }
            return collect([
                'hour' => $hour+1,
                'lastYear' => $amount,
                'today' => $todaySale,
                'lastYearAccumulated' => $lastYearAccumulated,
                'todayAccumulated' => $todayAccumulated,
                'relation' =>$relation,
            ]);
        });

        if (request()->header('X-Requested-With') === 'XMLHttpRequest'){
            return response()->json($amounts);
        }

        $data = [
            'amounts' => $amounts,
            'hourNow' => $hourNow,
            'todayFormatted' => $todayFormatted,
            'lastYearFormatted' => $lastYearFormatted
        ];
        return view('dashboard.index', $data);
    }
}
