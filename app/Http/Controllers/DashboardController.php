<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){


        $day = Carbon::today();
        $hourNow = (int) Carbon::now()->format('H');
        $isLive = true;

        if($request->all() != []){
            $day = Carbon::create($request->all()['dates1']);
            $hourNow = 23;
            $isLive = false;
        }

        $today = $day->copy()->format('Y-m-d'); // Fecha de hoy

        $lastYear = $day->copy()
            ->subYear() // Ir al mismo día del año pasado
        ->next($day->copy()->format('l')) // Ajustar al mismo día de la semana
            ->format('Y-m-d');
        $todayFormatted = Carbon::parse($today)->isoFormat('dddd D [de] MMMM YYYY');
        $lastYearFormatted = Carbon::parse($lastYear)->isoFormat('dddd D [de] MMMM YYYY');

        $queryLastyear = "EXEC dbo.DRSalesByHour @From = '{$lastYear}', @To = '{$lastYear}'";
        $lastyearResults = DB::connection('mssql')->selectResultSets($queryLastyear);
        $lastyearResults = collect($lastyearResults[0]);

        $queryToday = "EXEC dbo.DRSalesByHour @From = '{$today}' , @To = '{$today}'";
        $todayResults = DB::connection('mssql')->selectResultSets($queryToday);
        $todayResults = collect($todayResults[0]);

        // Se hace merge de los dos resultados en el atributo Hora para hacer map sobre todas.
        $allHoursObject = $lastyearResults->pluck('Hour')
            ->merge($todayResults->pluck('Hour'))
            ->unique()->sort()->values();
        $allHours = collect($allHoursObject);

        // Verificar si la hora actual existe en los resultados
        $hourNowExistsInTodayResults = $todayResults->where('Hour', $hourNow)->count() > 0;
        $hourNowExistsInLastYearResults = $lastyearResults->where('Hour', $hourNow)->count() > 0;
        if(!$hourNowExistsInTodayResults || !$hourNowExistsInLastYearResults) {
            $hourNow = $todayResults->max('Hour') ?? $hourNow -1 ?? 1;
//            $hourNow = $hourNow - 1;
        }

        $todayAccumulated = 0; $lastYearAccumulated = 0;
        $amounts = $allHours->map(function ($hour) use ($hourNow, &$todayAccumulated, &$lastYearAccumulated, $lastyearResults, $todayResults) {
            $lastyearSale = $lastyearResults->where('Hour', $hour)->first()->Amount ?? 0;
            $todaySale = $todayResults->where('Hour', $hour)->first()->Amount ?? 0;
            $lastYearAccumulated += $lastyearSale;
            $todayAccumulated += $todaySale;
            $relation = $lastYearAccumulated > 0 ? $todayAccumulated / $lastYearAccumulated * 100 : 0;
            $hour = (int) $hour;
            if($hour > $hourNow) {
                return collect([
                    'hour' => $hour+1,
                    'lastYear' => $lastyearSale,
                    'today' => $todaySale,
                    'lastYearAccumulated' => null,
                    'todayAccumulated' => null,
                    'lastYearAccumulatedFormatted' => null,
                    'todayAccumulatedFormatted' => null,
                    'relation' => null,
                ]);
            }
            return collect([
                'hour' => $hour+1,
                'lastYear' => $lastyearSale,
                'today' => $todaySale,
                'lastYearAccumulated' => $lastYearAccumulated,
                'todayAccumulated' => $todayAccumulated,
                'lastYearAccumulatedFormatted' => number_format($lastYearAccumulated, 0),
                'todayAccumulatedFormatted' => number_format($todayAccumulated, 0),
                'relation' =>(int)round($relation),
            ]);
        });
        $data = [
            'amounts' => $amounts,
            'hourNow' => $hourNow,
            'todayFormatted' => $todayFormatted,
            'lastYearFormatted' => $lastYearFormatted,
            'selectedDate1' => $today,
            'isLive' => $isLive
        ];

        if (request()->header('X-Requested-With') === 'XMLHttpRequest'){
            return response()->json($data);
        }

        return view('dashboard.index', $data);
    }
}
