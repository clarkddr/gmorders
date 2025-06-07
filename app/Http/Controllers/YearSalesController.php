<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Family;
use App\Transformers\SalesByYearReports\ByBranchTableTransformer;
use Illuminate\Http\Request;
use App\Services\SalesByYearReports\TotalizedSalesReportService;
use App\Transformers\SalesByYearReports\WeeklyChartTransformer;
use App\Transformers\SalesByYearReports\ByFamilyTableTransformer;

class YearSalesController extends Controller
{
    public function index(Request $request){
        $categories = Category::whereIn('CategoryId',[1,4,12])->get();
        $branches = Branch::whereNotIn('BranchId',[4,5,10,14])->get();
        $familiesWithCategories = Category::with('families')->whereIn('CategoryId',[1,2,4,12])->get();

//        if ($request->all() == []){
//            $data = [
//                'categories' => $categories,
//                'families' => $familiesWithCategories,
//                'branches' => $branches,
//                'chartData' => [],
//                'selectedBranch' => 0,
//                'selectedFamily' => 0
//            ];
//            return view('yearSales.index',$data);
//        }


        $from = '2024-6-7';
        $to = '2024x-06-7';
        $branchid = 0;
        $familyid = 0;//Family::where('Name','Sandalia')->first()->FamilyId;

        $families = Family::all();
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
        $branchesTableData = app(ByBranchTableTransformer::class)->transform($branchSales,$branches)['byBranch'];

        $data = [
            'chartData' => $chartData,
            'years' => $years,
            'familyRows' => $familiesTableData,
            'grandTotal' => $grandTotalRowFamilyTable,
            'branchRows' => $branchesTableData,
        ];

        return view('yearSales.index',$data);
    }
}
