<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Family;
use App\Models\Supplier;
use App\Transformers\Performance\ByCategoryTransformer;
use App\Transformers\Performance\ByResultsTransformer;
use App\Transformers\Performance\BySupplierTransformer;
use App\Transformers\SalesByYearReports\ByFamilyTableTransformer;
use Illuminate\Http\Request;
use App\Services\Performance\PerformanceService;
use App\Transformers\Performance\ByFamilyTransformer;
use App\Transformers\Performance\ByBranchTransformer;

class PerformanceController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::whereIn('CategoryId', [1, 2, 4, 12])->get();
        $branches = Branch::whereNotIn('BranchId', [4, 5, 10, 14])->get();
        $familiesWithCategories = Category::with('families')->whereIn('CategoryId', [1, 2, 4, 12])->get();
        $suppliers = Supplier::all()->sortBy('Name');
        // Obtener fechas para el dropdown de fechas
        $dates = DateHelper::getDefaultDateRanges();

        $data = [
            'families' => $familiesWithCategories,
            'categories' => $categories,
            'branches' => $branches,
            'suppliers' => $suppliers,
            'dates' => $dates,
            'selectedSupplier' => 0,
            'selectedBranch' => 0,
            'selectedFamily' => 0,
            'selectedCategory' => 0,
            'selectedDate1' => '',
            'selectedDate2' => '',
        ];

        if ($request->all() == []) {
            return view('performance.index', $data);
        }

        $categoryid = $request->input('category');
        $branchid = $request->input('branch');
        $familyid = $request->input('family');
        $supplierid = $request->input('supplier');
        $inputSaleDates = $request->input('dates1');
        $inputPurchaseDates = $request->input('dates2');

        $request->validate([
            'dates1' => 'required',
            'dates2' => 'required',
        ]);

        [$salesDatesFrom, $salesDatesTo] = DateHelper::parseDateRange($inputSaleDates);
        [$purchaseDatesFrom, $purchaseDatesTo] = DateHelper::parseDateRange($inputPurchaseDates);

        if ($salesDatesFrom >= $salesDatesTo || $purchaseDatesFrom >= $purchaseDatesTo) {
            {
                return redirect()->back()->withErrors(['sale_dates' => 'La fecha del primer rango debe ser anterior a la fecha del segundo rango.'])->withInput();
            }
        }

        $salesFrom = $salesDatesFrom;
        $salesTo = $salesDatesTo;
        $purchaseFrom = $purchaseDatesFrom;
        $purchaseTo = $purchaseDatesTo;

        $dbData = app(PerformanceService::class)->getData(
            $salesFrom, $salesTo, $purchaseFrom, $purchaseTo, $branchid, $familyid, $categoryid, $supplierid);

        $categoriesData = app(ByCategoryTransformer::class)->transform($dbData['byCategory']);
        $familiesData = app(ByFamilyTransformer::class)->transform($dbData['byFamily']);
        $branchesData = app(ByBranchTransformer::class)->transform($dbData['byBranch']);
        $suppliersData = app(BySupplierTransformer::class)->transform($dbData['bySupplier']);
        $resultsData = app(ByResultsTransformer::class)->transform($dbData['results']);

        $dataExtra = [
            'categoriesData' => $categoriesData,
            'familiesData' => $familiesData,
            'branchesData' => $branchesData,
            'suppliersData' => $suppliersData,
            'resultsData' => $resultsData,
            'selectedSupplier' => $supplierid,
            'selectedBranch' => $branchid,
            'selectedFamily' => $familyid,
            'selectedCategory' => $categoryid,
            'selectedDate1' => $inputSaleDates,
            'selectedDate2' => $inputPurchaseDates,
        ];

        $data = array_merge($data, $dataExtra);

        return view('performance.index', $data);
    }
}
