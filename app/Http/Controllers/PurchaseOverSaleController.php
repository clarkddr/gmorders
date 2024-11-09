<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Family;
use Illuminate\Support\Facades\DB;

class PurchaseOverSaleController extends Controller
{
    public function index(Request $request)
    {        
        $data = [
            'selectedDate' => '',
            'vars' => [
                'min' => 30,
                'max' => 50,
                'tc' => 19.00,
                'goal' => 40
            ],
            'categories' => collect([]),
        ];
        
        if($request->all() != []){
            $categoryList = collect(Category::with('families')->whereIn('CategoryId',[1,4,12])->get());

            $request->validate([
            'dates' => ['required'],
            'min' => ['required'],
            'max' => ['required'],
            'tc' => ['required'],
            'goal' => ['required'],
            ]);            
            $inputDates = $request->input('dates');                  
            if($inputDates != '' && $inputDates != 0){
                $dates = array_map('trim', explode('to', $inputDates));
                if(count($dates) == 1){
                    $dates[] = $dates[0];
                }
            }
            $date1 = Carbon::createFromFormat('Y-m-d', $dates[0])->setTime(0,0,0);
            $date2 = Carbon::createFromFormat('Y-m-d', $dates[1])->setTime(0,0,0);

            $vars['min'] = $request->input('min');
            $vars['max'] = $request->input('max');
            $vars['tc'] = $request->input('tc') ?? 18.00;
            $vars['goal'] = $request->input('goal') ?? 0;

            $query = "EXEC dbo.DRFamiliesPurchaseOverSale @From = '{$date1}', @To = '{$date2}'";
            $queryResults = DB::connection('mssql')->selectResultSets($query);
            
            // Resultados de Ventas
            $saleResults = collect($queryResults[0]);
            // Totalizados de Ventas
            $saleTotalResults = collect($queryResults[2]);
            // Resultado de compras
            $purchaseResults = collect($queryResults[1]);
            //Totalizado de Compras
            $purchaseTotalResults = collect($queryResults[3]); 
            
            // Sacamos el gran total
            $grandTotalSale = $saleTotalResults->sum('Sale') ?? 0;
            $grandTotalPurchaseCost = $purchaseTotalResults->sum('PurchaseCost') ?? 0;
            $grandTotalPurchaseSale = $purchaseTotalResults->sum('PurchaseSale') ?? 0;
            $grandTotalRelation = $grandTotalSale != 0 ? ($grandTotalPurchaseCost / $grandTotalSale * 100) : 0;
            $grandTotalToPurchaseDlls = (($grandTotalSale * $vars['goal'] / 100) - $grandTotalPurchaseCost) / $vars['tc'];
            $grandTotal = collect([
               'sale' => number_format($grandTotalSale,0),
               'purchaseCost' => number_format($grandTotalPurchaseCost,0),
               'purchaseSale' => number_format($grandTotalPurchaseSale,0),
               'relation' => number_format($grandTotalRelation,0),
               'toPurchaseDlls' => number_format($grandTotalToPurchaseDlls,0),
            ]);
            
            

            
            $familyListWithData = $categoryList->map(function ($category) use ($vars, $saleResults, $saleTotalResults, $purchaseResults, $purchaseTotalResults) {                
                $categoryPurchaseCost = $purchaseTotalResults->where('CategoryId', $category->CategoryId)->first()->PurchaseCost ?? 0;                
                $categoryPurchaseSale = $purchaseTotalResults->where('CategoryId', $category->CategoryId)->first()->PurchaseSale ?? 0;
                $categorySale = $saleTotalResults->where('CategoryId', $category->CategoryId)->first()->Sale ?? 0;
                $categoryTC = $purchaseTotalResults->where('CategoryId', $category->CategoryId)->first()->TC ?? 0;
                $categoryMargin = $purchaseTotalResults->where('CategoryId', $category->CategoryId)->first()->Margin ?? 0;
                $categoryRelation = $categorySale != 0 ? ($categoryPurchaseCost / $categorySale * 100) : 0;
                $categoryToPurchaseDlls = (($categorySale * $vars['goal'] / 100) - $categoryPurchaseCost) / $vars['tc'];
                return collect([
                    'id' => $category->CategoryId,
                    'name' => $category->Name,
                    'sale' => number_format($categorySale,0),
                    'purchaseCost' => number_format($categoryPurchaseCost,0),
                    'purchaseSale' => number_format($categoryPurchaseSale,0) ?? 0,
                    'relation' => number_format($categoryRelation,0),
                    'tc' => number_format($categoryTC,2),
                    'margin' => number_format($categoryMargin,0),
                    'toPurchaseDlls' => number_format($categoryToPurchaseDlls,0),
                    'families' => $category->families->map(function ($family) use ($vars,$saleResults, $purchaseResults) {
                        $familySale = $saleResults->where('FamilyId', $family->FamilyId)->first()->Sale ?? 0;
                        $familyPurchaseCost = $purchaseResults->where('FamilyId', $family->FamilyId)->first()->PurchaseCost ?? 0;
                        $familyPurchaseSale = $purchaseResults->where('FamilyId', $family->FamilyId)->first()->PurchaseSale ?? 0;
                        $familyTC = $purchaseResults->where('FamilyId', $family->FamilyId)->first()->TC ?? 0;
                        $familyMargin = $purchaseResults->where('FamilyId', $family->FamilyId)->first()->Margin ?? 0;
                        $familyRelation = $familySale != 0 ? ($familyPurchaseCost / $familySale * 100) : 0;
                        $familyToPurchaseDlls = (($familySale * $vars['goal'] / 100) - $familyPurchaseCost) / $vars['tc'];
                        return collect([
                            'familyId' => $family->FamilyId,
                            'name' => $family->Name,
                            'sale' => number_format($familySale,0),
                            'purchaseCost' => number_format($familyPurchaseCost,0),
                            'purchaseSale' => number_format($familyPurchaseSale,0),
                            'relation' => number_format($familyRelation,0),
                            'tc' => number_format($familyTC,2),
                            'margin' => number_format($familyMargin,0),
                            'toPurchaseDlls' => number_format($familyToPurchaseDlls,0),
                        ]);
                    })
                    
                ]);             
            });
            $data = [
                'selectedDate' => $inputDates,
                'categories' => $familyListWithData,
                'vars' => $vars,
                'grandTotal' => $grandTotal,
            ];
        
        }
        // dd($familyListWithData);
        return view('purchaseoversale.index',$data);
    }

    public function show($id, Request $request){
        $family = Family::with('category')->findOrFail($id);
        $familiesList = Family::with('category')->findOrFail($id)->category[0]->families;

        $data = [
            'selectedDate' => '',
            'vars' => [
                'min' => 30,
                'max' => 50,
                'tc' => 19.00,
                'goal' => 40
            ],
            'categories' => collect([]),
        ];

        if($request->all() != []){
            $branches = Branch::whereNotIn('BranchId',[4,5,10,14])->get();
            
            
            $inputDates = $request->input('dates');                  
            if($inputDates != '' && $inputDates != 0){
                $dates = array_map('trim', explode('to', $inputDates));
                if(count($dates) == 1){
                    $dates[] = $dates[0];
                }
            }
            $date1 = Carbon::createFromFormat('Y-m-d', $dates[0])->setTime(0,0,0);
            $date2 = Carbon::createFromFormat('Y-m-d', $dates[1])->setTime(0,0,0);

            $vars['min'] = $request->input('min');
            $vars['max'] = $request->input('max');
            $vars['tc'] = $request->input('tc') ?? 18.00;
            $vars['goal'] = $request->input('goal') ?? 0;

            $query = "EXEC dbo.DRFamilyPurchaseOverSale @From = '{$date1}', @To = '{$date2}', @FamilyId = {$family->FamilyId}";
            $queryResults = DB::connection('mssql')->selectResultSets($query);

            $saleResults = collect($queryResults[0]);
            $purchaseResults = collect($queryResults[1]);
           

            // Se sacan los totales de cada tabla
            $totalSale = $saleResults->sum('Sale') ?? 0;
            $totalPurchaseCost = $purchaseResults->sum('PurchaseCost') ?? 0;
            $totalPurchaseSale = $purchaseResults->sum('PurchaseSale') ?? 0;
            $totalRelation = $totalSale != 0 ? ($totalPurchaseCost / $totalSale * 100) : 0;
            $totalTC = $purchaseResults->average('TC') ?? 18.00;
            $totalToPurchaseDlls = (($totalSale * $vars['goal'] / 100) - $totalPurchaseCost) / $vars['tc'];
            $family =  collect([                
                'familyId' => $family->FamilyId,
                'name' => $family->Name,
                'sale' => number_format($totalSale,0),
                'purchaseCost' => number_format($totalPurchaseCost,0),
                'purchaseSale' => number_format($totalPurchaseSale,0),
                'relation' => number_format($totalRelation,0),
                'tc' => number_format($totalTC,2),
                'toPurchaseDlls' => number_format($totalToPurchaseDlls,0),
            ]);  

            $branchListWithData = $branches->map(function ($branch) use ($vars, $saleResults, $purchaseResults) {
                $branchSale = $saleResults->firstWhere('BranchId', $branch->BranchId)->Sale ?? 0;                
                $branchPurchaseCost = $purchaseResults->firstWhere('BranchId', $branch->BranchId)->PurchaseCost ?? 0;
                $branchPurchaseSale = $purchaseResults->firstWhere('BranchId', $branch->BranchId)->PurchaseSale ?? 0;
                $branchRelation = $branchSale != 0 ? ($branchPurchaseCost / $branchSale * 100) : 0;
                $branchTC = $purchaseResults->firstWhere('BranchId', $branch->BranchId)->TC ?? 0;
                $branchToPurchaseDlls = (($branchSale * $vars['goal'] / 100) - $branchPurchaseCost) / $vars['tc'];
                return collect([
                    'id' => $branch->BranchId,
                    'name' => $branch->Name,
                    'sale' => number_format($branchSale,0),
                    'purchaseCost' => number_format($branchPurchaseCost,0),
                    'purchaseSale' => number_format($branchPurchaseSale,0),
                    'relation' => number_format($branchRelation,0),
                    'tc' => number_format($branchTC,2),
                    'toPurchaseDlls' => number_format($branchToPurchaseDlls,0),
                ]);
            });
            // dd([$totals,$branchListWithData]);

            $data = [
                'selectedDate' => $inputDates,
                'vars' => $vars,
                'family' => $family,
                'familiesList' => $familiesList,
                'branches' => $branchListWithData,
            ];
        }
        // dd($data);
        return view('purchaseoversale.show', $data);
    }
}
