<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Family;
use App\Transformers\SalesByYearReports\ByBranchTableTransformer;
use Illuminate\Http\Request;
use App\Services\SalesByYearReports\TotalizedSalesReportService;
use App\Transformers\SalesByYearReports\WeeklyChartTransformer;
use App\Transformers\SalesByYearReports\ByFamilyTableTransformer;


class YearSalesController extends Controller
{
    public function index(Request $request){
        $from = '2025-05-01';
        $to = '2025-05-23';
        $branchid = 0;
        $familyid = 0;

        $families = Family::all();
        $branches = Branch::whereNot('BranchId',[4,5,10,14])->get();
        // Se obtienen las ventas que contiene los tres reportes, por semana, por familia y por sucursal
        $report = app(TotalizedSalesReportService::class)->getData($from,$to,$branchid,$familyid);
        // Se obtiene el reporte de ventas por semana
        $weeklySales = $report['weeks'];
        // Se transforma las ventas por semana para usarlo en la gráfica
        $chartData = app(WeeklyChartTransformer::class)->transform($weeklySales);
        // Se obtienen las ventas por familia
        $familiesSales = $report['byFamily'];
        // Se transforman para poder usarlo como tabla en la vista
        $familiesTableData = app(ByFamilyTableTransformer::class)->transform($familiesSales,$families)['byFamily'];
        $grandTotalRowFamilyTable = app(ByFamilyTableTransformer::class)->transform($familiesSales,$families)['totalRow'];
        $years = app(ByFamilyTableTransformer::class)->getYears($familiesSales);

        // Se obtienen las ventas por Sucursal
        $branchSales = $report['byBranch'];
        // Se transforman para poder usarlo como tabla en la vista
        $branchesTableData = app(ByBranchTableTransformer::class)->transform($branchSales,$branches);

        $data = [
            'chartData' => $chartData,
            'years' => $years,
            'familyRows' => $familiesTableData,
            'familyGrandTotal' => $grandTotalRowFamilyTable,
            'branchRows' => $branchesTableData
        ];

//        dd($data);

        return view('yearSales.index',$data);
    }
}
