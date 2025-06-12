<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Family;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\DateHelper;


class SaleandPurchaseController extends Controller
{
    public function index(Request $request){
        $categories = Category::whereIn('CategoryId',[1,4,12])->get();
        $branches = Branch::whereNotIn('BranchId',[4,5,10,14])->get();
        $familiesList = Category::with('families')->whereIn('CategoryId',[1,2,4,12])->get();

        // Obtener fechas para el dropdown de fechas
        // 29May-11Jun 2025 vs 30May-12Jun 2024
        $dates = DateHelper::getDefaultDateRanges();

        $data = [
            'selectedDate1' => '',
            'selectedDate2' => '',
            'selectedCategory' => 0,
            'selectedBranch' => 0,
            'selectedFamily' => 0,
            'categoriesList' => $categories,
            'branchesList' => $branches,
            'familiesList' => $familiesList,
            'suppliers' => [],
            'families' => [],
            'branches'  => [],
            'totals' => ['sale1'=>0,'sale2'=>0,'sale0'=>0,'purchase1'=>0,'purchase2'=>0,'purchase0'=>0,'saleRelation'=>0,'purchaseVsSale1'=>0,'purchaseVsSale2'=>0,'purchaseRelation'=>0],
            'dates' => $dates,
        ];

//        dd($data);

        if($request->all() != []){

            $request->validate([
                'dates1' => ['required'],
                'dates2' => ['required'],
                'category' => ['required'],
            ]);

            $inputCategory = $request->input('category');
            $inputBranch = $request->input('branch');
            $inputFamily = $request->input('family');
            $inputDates1 = $request->input('dates1');
            $inputDates2 = $request->input('dates2');

            if($inputCategory == 0){
                $families = Family::all();
            } else {
                $category = Category::findOrFail($inputCategory);
                $families = $category->families;
            }

            [$fromDate1, $toDate1] = DateHelper::parseDateRange($inputDates1);
            [$fromDate2, $toDate2] = DateHelper::parseDateRange($inputDates2);


            // Validación adicional
            if ($fromDate1 >= $fromDate2) {
                return redirect()->back()->withErrors(['dates1' => 'La fecha del primer rango debe ser anterior a la fecha del segundo rango.'])->withInput();
            }

            //    if ($toDate1 >= $toDate2) {
            //        return redirect()->back()->withErrors(['dates1' => 'La fecha del primer rango debe ser anterior a la fecha del segundo rango.'])->withInput();
            //    }
            if ($toDate1 >= $fromDate2) {
                return redirect()->back()->withErrors(['dates1' => 'La fecha del primer rango debe ser anterior a la fecha del segundo rango.'])->withInput();
            }

//            dd([$fromDate1,$toDate2]);


            $query = "
            EXEC dbo.DRGetFamilySalesPurchasesTwoDates2 @From = '{$fromDate1}', @to1 = '{$toDate1}',
                @From2 = '{$fromDate2}', @To = '{$toDate2}',
                @Category = {$inputCategory}, @branch = {$inputBranch}, @family = {$inputFamily}
            ";
            $queryResults = DB::connection('mssql')->selectResultSets($query);

            // Resultados de Ventas y compras tabla familias
            $familySaleResult = collect($queryResults[0]);
            $familyPurchaseResult = collect($queryResults[1]);
            // Se sacan los totales solo una vez porque las tablas lo comparten
            $totals = collect([
                'sale1' => number_format($familySaleResult->sum('firstRange'),0),
                'sale2' => number_format($familySaleResult->sum('secondRange'),0),
                'purchase1' => number_format($familyPurchaseResult->sum('firstRange'),0),
                'purchase2' => number_format($familyPurchaseResult->sum('secondRange'),0),
                'saleRelation' => number_format($familySaleResult->sum('firstRange') != 0 ?
                    $familySaleResult->sum('secondRange') / $familySaleResult->sum('firstRange') * 100 : 0,0),
                'purchaseRelation' => number_format($familyPurchaseResult->sum('firstRange') != 0 ?
                    $familyPurchaseResult->sum('secondRange') / $familyPurchaseResult->sum('firstRange') * 100 : 0,0),
                'purchaseVsSale1' => number_format($familySaleResult->sum('firstRange') != 0 ?
                    $familyPurchaseResult->sum('firstRange') / $familySaleResult->sum('firstRange') * 100 : 0,0),
                'purchaseVsSale2' => number_format($familySaleResult->sum('secondRange') != 0 ?
                    $familyPurchaseResult->sum('secondRange') / $familySaleResult->sum('secondRange') * 100 : 0,0),
            ]);
            $familiesAmounts = $families->map(function ($family) use ($familySaleResult, $familyPurchaseResult) {
                $sale1 = $familySaleResult->where('FamilyId', $family->FamilyId)->first()->firstRange ?? 0;
                $sale2 = $familySaleResult->where('FamilyId', $family->FamilyId)->first()->secondRange ?? 0;
                $saleRelation = $sale1 != 0 ? $sale2 / $sale1 * 100 : 0;
                $purchase1 = $familyPurchaseResult->where('FamilyId', $family->FamilyId)->first()->firstRange ?? 0;
                $purchase2 = $familyPurchaseResult->where('FamilyId', $family->FamilyId)->first()->secondRange ?? 0;
                $purchaseVsSale1 = $sale1 != 0 ? $purchase1 / $sale1 * 100 : 0;
                $purchaseVsSale2 = $sale2 != 0 ? $purchase2 / $sale2 * 100 : 0;
                $purchaseRelation = $purchase1 != 0 ? $purchase2 / $purchase1 * 100 : 0;
                return collect([
                    'familyid' => $family->FamilyId,
                    'name' => $family->Name,
                    'sale1' => number_format($sale1,0),
                    'sale2' => number_format($sale2,0),
                    'saleRelation' => number_format($saleRelation,0),
                    'purchase1' => number_format($purchase1,0),
                    'purchase2' => number_format($purchase2,0),
                    'purchaseVsSale1' => number_format($purchaseVsSale1,0),
                    'purchaseVsSale2' => number_format($purchaseVsSale2,0),
                    'purchaseRelation' => number_format($purchaseRelation,0),
                ]);
            });
            // Resultados de Ventas y compras tabla sucursales
            $branchSaleResult = collect($queryResults[2]);
            $branchPurchaseResult = collect($queryResults[3]);

            $branchesAmounts = $branches->map(function ($branch) use ($branchSaleResult, $branchPurchaseResult) {
                $sale1 = $branchSaleResult->where('BranchId', $branch->BranchId)->first()->firstRange ?? 0;
                $sale2 = $branchSaleResult->where('BranchId', $branch->BranchId)->first()->secondRange ?? 0;
                $saleRelation = $sale1 != 0 ? $sale2 / $sale1 * 100 : 0;
                $purchase1 = $branchPurchaseResult->where('BranchId', $branch->BranchId)->first()->firstRange ?? 0;
                $purchase2 = $branchPurchaseResult->where('BranchId', $branch->BranchId)->first()->secondRange ?? 0;
                $purchaseVsSale1 = $sale1 != 0 ? $purchase1 / $sale1 * 100 : 0;
                $purchaseVsSale2 = $sale2 != 0 ? $purchase2 / $sale2 * 100 : 0;
                $purchaseRelation = $purchase1 != 0 ? $purchase2 / $purchase1 * 100 : 0;
                return collect([
                    'branchid' => $branch->BranchId,
                    'name' => $branch->Name,
                    'sale1' => number_format($sale1,0),
                    'sale2' => number_format($sale2,0),
                    'saleRelation' => number_format($saleRelation,0),
                    'purchase1' => number_format($purchase1,0),
                    'purchase2' => number_format($purchase2,0),
                    'purchaseVsSale1' => number_format($purchaseVsSale1,0),
                    'purchaseVsSale2' => number_format($purchaseVsSale2,0),
                    'purchaseRelation' => number_format($purchaseRelation,0),
                ]);
            });

            // Resultados de Ventas y compras tabla Proveedores
            $supplierSaleResult = collect($queryResults[4]);
            $supplierPurchaseResult = collect($queryResults[5]);
            $suppliers = Supplier::all()->keyBy('SupplierId');

            $suppliersAmounts = $suppliers->map(function ($supplier) use ($supplierSaleResult, $supplierPurchaseResult) {
                $supplierId = $supplier->SupplierId;
                $sale1 = $supplierSaleResult->where('SupplierId', $supplierId)->first()->firstRange ?? 0;
                $sale2 = $supplierSaleResult->where('SupplierId', $supplierId)->first()->secondRange ?? 0;
                $saleRelation = $sale1 != 0 ? $sale2 / $sale1 * 100 : 0;
                $purchase1 = $supplierPurchaseResult->where('SupplierId', $supplierId)->first()->firstRange ?? 0;
                $purchase2 = $supplierPurchaseResult->where('SupplierId', $supplierId)->first()->secondRange ?? 0;
                $purchaseVsSale1 = $sale1 != 0 ? $purchase1 / $sale1 * 100 : 0;
                $purchaseVsSale2 = $sale2 != 0 ? $purchase2 / $sale2 * 100 : 0;
                $purchaseRelation = $purchase1 != 0 ? $purchase2 / $purchase1 * 100 : 0;
                // Retorna nulo si todas las métricas son 0 (para filtrar luego)
                if ($sale1 == 0 && $sale2 == 0 && $purchase1 == 0 && $purchase2 == 0) {
                    return null;
                }
                return collect([
                    'supplierid' => $supplierId,
                    'name' => $supplier->Name,
                    'sale1' => number_format($sale1,0),
                    'sale2' => number_format($sale2,0),
                    'saleRelation' => number_format($saleRelation,0),
                    'purchase1' => number_format($purchase1,0),
                    'purchase2' => number_format($purchase2,0),
                    'purchaseVsSale1' => number_format($purchaseVsSale1,0),
                    'purchaseVsSale2' => number_format($purchaseVsSale2,0),
                    'purchaseRelation' => number_format($purchaseRelation,0),
                ]);
            })->filter();


            $data['selectedDate1'] = $inputDates1;
            $data['selectedDate2'] = $inputDates2;
            $data['selectedCategory'] = $inputCategory;
            $data['selectedFamily'] = $inputFamily;
            $data['selectedBranch'] = $inputBranch;
            $data['families'] = $familiesAmounts;
            $data['branches'] = $branchesAmounts;
            $data['suppliers'] = $suppliersAmounts;
            $data['totals'] = $totals;
        }

        return view('saleandpurchase.index',$data);
    }
}
