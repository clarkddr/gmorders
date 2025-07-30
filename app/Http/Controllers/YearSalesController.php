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
use App\Helpers\DateHelper;

class YearSalesController extends Controller
{
    public function index(Request $request){
        $categories = Category::whereIn('CategoryId',[1,2,4,12])->get();
        $branches = Branch::whereNotIn('BranchId',[4,5,10,14])->get();
        $familiesWithCategories = Category::with('families')->whereIn('CategoryId',[1,2,4,12])->get();
        // Obtener fechas para el dropdown de fechas
        $dates = DateHelper::getDefaultDateRanges();

        if ($request->all() == []){
            $data = [
                'categories' => $categories,
                'families' => $familiesWithCategories,
                'branches' => $branches,
                'chartData' => [],
                'selectedBranch' => 0,
                'selectedFamily' => 0,
                'selectedCategory' => 0,
                'selectedDate1' => '',
                'dates' => $dates,
            ];
            return view('yearsales.index',$data);
        }

        // Validar datos
        $request->validate([
            'dates1' => ['required'],
            'category' => ['required'],
        ]);

        $inputCategory = $request->input('category');
        $inputBranch = $request->input('branch');
        $inputFamily = $request->input('family');
        $inputDates = $request->input('dates1');

        // Pasar fechas con el helper para descomponerlas en caso de que sean rango
        [$fromDate, $toDate] = DateHelper::parseDateRange($inputDates);

        $from = $fromDate->format('Y-m-d');
        $to = $toDate->format('Y-m-d');
        $branchid = Branch::where('BranchId',$inputBranch)->first()->BranchId ?? 0;
        $familyid = Family::where('FamilyId',$inputFamily)->first()->FamilyId ?? 0;
        $categoryid = Category::where('CategoryId',$inputCategory)->first()->CategoryId ?? 0;
        $families = Family::all();
        // Se obtienen las ventas que contiene los tres reportes, por semana, por familia y por sucursal
        $report = app(TotalizedSalesReportService::class)->getData($from,$to,$branchid,$familyid,$categoryid);
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
            'categories' => $categories,
            'families' => $familiesWithCategories,
            'branches' => $branches,
            'selectedBranch' => $branchid,
            'selectedFamily' => $familyid,
            'selectedCategory' => $inputCategory,
            'selectedDate1' => $inputDates,
            'dates' => $dates,
        ];

        return view('yearsales.index',$data);
    }
}
