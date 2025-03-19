<?php

namespace App\Http\Controllers;

use App\Models\Projection;
use Illuminate\Support\Facades\DB;
use App\Models\BranchSalesTarget;
use Carbon\Carbon;

class BranchSalesTargetController extends Controller
{
    public function show($slug){
        Carbon::setLocale('es');
        $branchid = BranchSalesTarget::where('slug', $slug)->first()->branch_id;
        $branchid = 24; // QUITAR ESTE DATO

        $date = Carbon::today();
        $month = $date->translatedFormat('F');

        $lastDayOfMonth = Carbon::now()->copy()->endOfMonth();
        function getDaysOfMonth($currentDay){
            // Crear una instancia de Carbon para el día actual
            $currentDate = Carbon::parse($currentDay);

            // Obtener el primer día del mes
            $startDate = $currentDate->copy()->startOfMonth();

            // Obtener el último día del mes
            $endDate = $startDate->copy()->endOfMonth();

            // Crear un array con todos los días del mes
            $daysOfMonth = [];

            while ($startDate <= $endDate) {
                $daysOfMonth[] = $startDate->format('Y-m-d'); // Formato de fecha
                $startDate->addDay(); // Mover al siguiente día
            }

            return $daysOfMonth;
        }
        // Se recolectan todos los dias del mes actual para iterar sobre ellos.
        $today = Carbon::today()->format('Y-m-d');
        $daysOfMonth = collect(getDaysOfMonth($today));

        // Function para obtener ventas por dia, parametos: desde, hasta, sucursal
        function getSaleByDays($from, $to, $branch){
            $query = "EXEC DRBranchSalesByDay @From = '{$from}', @To = '{$to}', @branch = {$branch}";
            $queryResults = DB::connection('mssql')->selectResultSets($query);
            $saleResults = collect($queryResults[0]);
            return $saleResults;
        }

        //function para obtener el porcentaje de comparacion de dos rangos de fechas,
        // proveyendo solo el de el año en curso y calcula exactamente los mismo dias del año anterior.
        // Parametros: desde, hasta, sucursal, Retorna total de comparacion de venta.
        function getTotalSale($from, $to, $branch){
            $query = "EXEC DRBranchSalesByDay @From = '{$from}', @To = '{$to}', @branch = {$branch}";
            $queryResults = DB::connection('mssql')->selectResultSets($query);
            $saleResults = collect($queryResults[1]);
            return $saleResults->sum('Amount');
        }

        // Obtenemos el total proyectado
        $projection = Projection::where('name','Anual 2025')->first()->projectionamounts;
        $projectionAmount = $projection
                ->when($branchid != 0, fn($query) => $query->where('BranchId', $branchid))
                ->sum('new_sale')
            + $projection
                ->when($branchid != 0, fn($query) => $query->where('BranchId', $branchid))
                ->sum('old_sale');
        $firstDayOfLastYear = Carbon::now()->subYear()->startOfYear()->format('Y-m-d H:i:s');
        $lastDayOfLastYear = Carbon::now()->subYear()->endOfYear()->format('Y-m-d H:i:s');

        $totalSaleWholeLastYear = getTotalSale($firstDayOfLastYear, $lastDayOfLastYear, $branchid);
        $goal = $totalSaleWholeLastYear > 0 ? $projectionAmount / $totalSaleWholeLastYear : 1;

        // Se calculan los dias para sacar el total de venta del mes en el año pasado.
        $firstDayOfMonthLastYear = Carbon::now()->subYear()->startOfMonth()->format('Y-m-d');
        $nowLastYear = Carbon::now()->subYear()->format('Y-m-d H:i:s');
        $totalMonthSaleLastYear = getTotalSale($firstDayOfMonthLastYear, $nowLastYear, $branchid) * $goal;

        $firstDayOfMonthThisYear = Carbon::now()->startOfMonth()->format('Y-m-d');
        $nowThisYear = Carbon::now()->format('Y-m-d H:i:s');
        $totalMonthSaleThisYear = getTotalSale($firstDayOfMonthThisYear, $nowThisYear, $branchid);
        // Se saca la relacion del mes
        $saleMonthRelation = $totalMonthSaleThisYear > 0 ? $totalMonthSaleThisYear / $totalMonthSaleLastYear * 100 : 0;
        //361076/564627= 0.63


        // Se calculan los dias para sacar el total de venta del año en curso y el anterior al momento
        $firstDayOfYearLastYear = Carbon::now()->subYear()->startOfYear()->format('Y-m-d');
        $totalYearSaleLastYear = getTotalSale($firstDayOfYearLastYear, $nowLastYear, $branchid) * $goal ;

        $firstDayOfYearThisYear = Carbon::now()->startOfYear()->format('Y-m-d');
        $totalYearSaleThisYear = getTotalSale($firstDayOfYearThisYear, $nowThisYear, $branchid);
        // Se saca la relacion del mes
        $saleYearRelation = $totalYearSaleLastYear > 0 ? $totalYearSaleThisYear / $totalYearSaleLastYear * 100 : 0;
        // 5,232,283 / 4,912,728 = 1.06

        // Se calculan los dias para sacar el total de venta de ayer
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $yesterdayEnd = Carbon::yesterday()->addDay()->format('Y-m-d');
        $yesterdayLastYear = Carbon::yesterday()->subYear()->addDay()->format('Y-m-d');
        $ysterdayLastYearEnd = Carbon::yesterday()->subYear()->addDay(2)->format('Y-m-d');
        $totalSaleYesterdayThisYear = getTotalSale($yesterday, $yesterdayEnd, $branchid);
        $totalSaleYesterdayLastYear = getTotalSale($yesterdayLastYear, $ysterdayLastYearEnd, $branchid) * $goal;
        $saleYesterdayRelation = $totalSaleYesterdayLastYear > 0 ? $totalSaleYesterdayThisYear / $totalSaleYesterdayLastYear * 100 : 0;

        // Se obtienen las ventas por dia del año en curso y del anterior hasta el momento. OJO El año anterior se le agrega un dia para poder comparar lunes-lunes
        $lastYearCurrent = Carbon::now()->copy()->subYear()->addDay();
        $thisYearsaleResults = getSaleByDays($firstDayOfMonthThisYear, $lastDayOfMonth->format('Y-m-d'), $branchid);
        $lastYearsaleResults = getSaleByDays($firstDayOfMonthLastYear, $lastYearCurrent->format('Y-m-d H:i:s'), $branchid);


        $results = $daysOfMonth->map(function ($date) use ($thisYearsaleResults, $lastYearsaleResults, $goal) {
            $dayLastYear = Carbon::parse($date)->subYear()->addDay();
            $day = Carbon::parse($date)->day;
//            dd($dayLastYear);
            $thisYearSale = $thisYearsaleResults->where('Date', $date)->sum('Amount') ?? 0;
            $lastYearSale = $lastYearsaleResults->where('Date', $dayLastYear->format('Y-m-d'))->sum('Amount') * $goal ?? 0;
            $relation = $lastYearSale > 0 ? $thisYearSale / $lastYearSale * 100 : 0;
            return collect([
                'day' => $day,
                'date' => $date,
                'thisYearSale' => $thisYearSale,
                'lastYearSale' => $lastYearSale,
                'relation' => $relation,
            ]);
        });


        $todayRelation = $results->where('date', $today)->first()['relation'];


        $todayFormatted = Carbon::now()->isoFormat('dddd D [de] MMMM YYYY');
        $lastYearFormatted = Carbon::now()->subYear()->addDay()->isoFormat('dddd D [de] MMMM YYYY');

        $data = [
            'results' => collect($results),
            'yearRelation' => $saleYearRelation,
            'monthRelation' => $saleMonthRelation,
            'yesterdayRelation' => $saleYesterdayRelation,
            'todayRelation' => $todayRelation,
            'branchid' => $branchid,
            'today' => $todayFormatted,
            'lastYear' => $lastYearFormatted,
            'month' => $month
        ];
        return view('branchSalesTarget.show', $data);
    }
}
