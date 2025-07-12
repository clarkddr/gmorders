<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Family;
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
    public function index(Request $request){


        $salesFrom = '2025-1-1';
        $salesTo = '2025-7-31';
        $purchaseFrom = $salesFrom;
        $purchaseTo = $salesTo;
        $categoryid = 0;
        $familyid = 0;//Family::where('Name', 'Zapatilla')->first()->FamilyId;
        $branchid = 0;
        $supplierid = 0;

        $dbData = app(PerformanceService::class)->getData(
            $salesFrom, $salesTo, $purchaseFrom, $purchaseTo, $branchid, $familyid, $categoryid, $supplierid);

        $categoriesData = app(ByCategoryTransformer::class)->transform($dbData['byCategory']);
        $familiesData = app(ByFamilyTransformer::class)->transform($dbData['byFamily']);
        $branchesData = app(ByBranchTransformer::class)->transform($dbData['byBranch']);
        $suppliersData = app(BySupplierTransformer::class)->transform($dbData['bySupplier']);
        $resultsData = app(ByResultsTransformer::class)->transform($dbData['results']);

        $data = [
            'categoriesData' => $categoriesData,
            'familiesData' => $familiesData,
            'branchesData' => $branchesData,
            'suppliersData' => $suppliersData,
            'resultsData' => $resultsData
        ];

        return view('performance.index', $data);


    }
}
