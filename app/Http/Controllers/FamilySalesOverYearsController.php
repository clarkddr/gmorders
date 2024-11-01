<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilySalesOverYearsController extends Controller
{
    public function index(){
        $categories = Category::whereIn('CategoryId',[1,4,12])->get();
        $data = [
            'selectedDate' => '',
            'selectedCategory' => 0,
            'categories' => $categories,
            'amounts' => [],
            'totalSales' => ['sale2' => 0, 'sale1' => 0, 'sale0' => 0,'relation0vs1' => 0, 'relation0vs2' => 0],
            'totalPurchase' => ['purchase2' => 0, 'purchase1' => 0, 'purchase0' => 0,
            'relation2' => 0, 'relation1' => 0, 'relation0' => 0],
        ];
        
        return view('salesYoy.index',$data);
    }

    public function show(Request $request){
        $categories = Category::whereIn('CategoryId',[1,4,12])->get();
        $data = [
            'selectedDate' => '',
            'selectedCategory' => 0,
            'categories' => $categories,
            'amounts' => [],
            'totalSales' => ['sale2' => 0, 'sale1' => 0, 'sale0' => 0,'relation0vs1' => 0, 'relation0vs2' => 0],
            'totalPurchase' => ['purchase2' => 0, 'purchase1' => 0, 'purchase0' => 0,
            'relation2' => 0, 'relation1' => 0, 'relation0' => 0],
            
        ];

        if($request->all() != []){

            $request->validate([
            'dates' => ['required'],
            'category' => ['required','not_in:Departamento'], 
            ]);
            $inputCategory = $request->input('category');
            $inputDates = $request->input('dates');

            $category = Category::findOrFail($inputCategory);        
            if($inputDates != '' && $inputDates != 0){
                $dates = array_map('trim', explode('to', $inputDates));
                if(count($dates) == 1){
                    $dates[] = $dates[0];
                }
            }

            $date1 = Carbon::createFromFormat('Y-m-d', $dates[0])->setTime(0,0,0)->subYear(2);
            $date2 = Carbon::createFromFormat('Y-m-d', $dates[1])->setTime(0,0,0);
            
            $query = "
            EXEC dbo.DRGetFamilySalesOverYears @From = '{$date1}', @To = '{$date2}', @Category = {$category->CategoryId}
            ";
            $queryResults = DB::connection('mssql')->selectResultSets($query);
            
            // Resultados de Ventas
            $results = collect($queryResults[0]);
            // Resultado de compras
            $purchaseResults = collect($queryResults[1]);

            
            $totalSales = $results->reduce(function ($carry, $item) {
                $sale2 = $carry['sale2'] + $item->sale2;
                $sale1 = $carry['sale1'] + $item->sale1;
                $sale0 = $carry['sale0'] + $item->sale0;
                $relation0vs1 = $sale1 != 0 ? $sale0 / $sale1 * 100 : 0;
                $relation0vs2 = $sale2 != 0 ? $sale0 / $sale2 * 100 : 0;
                return collect([
                    'sale2' => $sale2,
                    'sale1' => $sale1,
                    'sale0' => $sale0,
                    'relation0vs1' => $relation0vs1,
                    'relation0vs2' => $relation0vs2,
                ]);    
            },['sale2' => 0, 'sale1' => 0, 'sale0' => 0]);

            $totalPurchase = $purchaseResults->reduce(function ($carry, $item) use($totalSales) {
                $purchase0 = $carry['purchase0'] + $item->purchase0;
                $purchase1 = $carry['purchase1'] + $item->purchase1;
                $purchase2 = $carry['purchase2'] + $item->purchase2;
                $relation0 = $totalSales['sale0'] != 0 ? $purchase0 / $totalSales['sale0'] * 100 : 0; 
                $relation1 = $totalSales['sale1'] != 0 ? $purchase1 / $totalSales['sale1'] * 100 : 0;
                $relation2 = $totalSales['sale2'] != 0 ? $purchase2 / $totalSales['sale2'] * 100 : 0;

                return collect([
                    'purchase2' => $purchase2,
                    'purchase1' => $purchase1,
                    'purchase0' => $purchase0,
                    'relation2' => $relation2,
                    'relation1' => $relation1,
                    'relation0' => $relation0,
                ]);    
            },['purchase2' => 0, 'purchase1' => 0, 'purchase0' => 0]);
            
            $totalPurchaseFormatted = collect($totalPurchase)->map(function ($value) {
                return number_format($value, 0); // Formatea cada valor
            });
            
            $totalSalesFormatted = collect($totalSales)->map(function ($value) {
                return number_format($value, 0); // Formatea cada valor
            });

            $amounts = $results->map(function ($row) use ($purchaseResults) {
                $purchase = $purchaseResults->where('familyid', $row->FamilyId)->first();
                $relation0 = $row->sale0 != 0 ? $purchase->purchase0 / $row->sale0 * 100 : 0; 
                $relation1 = $row->sale1 != 0 ? $purchase->purchase1 / $row->sale1 * 100 : 0;
                $relation2 = $row->sale2 != 0 ? $purchase->purchase2 / $row->sale2 * 100 : 0;
                $relation0vs1 = $row->sale1 != 0 ? $row->sale0 / $row->sale1 * 100 : 0;
                $relation0vs2 = $row->sale2 != 0 ? $row->sale0 / $row->sale2 * 100 : 0;
                return collect([
                    'familyid' => $row->FamilyId,
                    'name' => $row->Name,
                    'sale2' => number_format($row->sale2,0),
                    'sale1' => number_format($row->sale1,0),
                    'sale0' => number_format($row->sale0,0),
                    'relation0vs1' => number_format($relation0vs1,0),
                    'relation0vs2' => number_format($relation0vs2,0),
                    'purchase2' => number_format($purchase->purchase2,0),
                    'relation2' => number_format($relation2,0),
                    'purchase1' => number_format($purchase->purchase1,0),
                    'relation1' => number_format($relation1,0),
                    'purchase0' => number_format($purchase->purchase0,0),
                    'relation0' => number_format($relation0,0),
                ]); 
            });    

               
            // Resultados de Compras


            $data = [
                'selectedDate' => $request->input('dates'),
                'selectedCategory' => $category,
                'categories' => $categories,
                'amounts' => $amounts,
                'totalSales' => $totalSalesFormatted,
                'totalPurchase' => $totalPurchaseFormatted,
            ];

        }
        

        return view('salesYoy.index',$data);

        
    }
}
