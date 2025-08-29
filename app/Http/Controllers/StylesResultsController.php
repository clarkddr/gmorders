<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Supplier;
use App\Repositories\StylesResults\StylesResultsRepository;
use Illuminate\Http\Request;

class StylesResultsController extends Controller
{
    public function index(Request $request, StylesResultsRepository $stylesResultsRepository){
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
            'threshold' => 50
        ];

        if ($request->all() == []) {
            return view('stylesResults.index',$data);
        }



        $categoryId = $request->input('category');
        $familyId = $request->input('family');
        $subcategoryId = 0;
        $branchId = $request->input('branch');
        $supplierId = $request->input('supplier');
        $threshold = $request->input('threshold');
        $inputDates = $request->input('dates1');

        $request->validate([
            'dates1' => 'required',
        ]);

        [$from, $to] = DateHelper::parseDateRange($inputDates);

        $stylesData = $stylesResultsRepository->getStylesResults($from, $to,
            $categoryId, $familyId, $subcategoryId, $branchId, $supplierId, $threshold);

        $extraData = [
            'selectedDate1' => $inputDates,
            'selectedSupplier' => $supplierId,
            'selectedBranch' => $branchId,
            'selectedFamily' => $familyId,
            'selectedCategory' => $categoryId,
            'threshold' => $threshold,
            'dates' => $dates,
            'styles' => $stylesData['stylesResults'],
            'styleDetail' => $stylesData['stylesResultsDetail'],
        ];

        $data = array_merge($data, $extraData);

        return view('stylesResults.index',$data);
    }
}
