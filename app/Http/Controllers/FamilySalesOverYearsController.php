<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilySalesOverYearsController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::whereIn('CategoryId', [1, 4, 12])->get();
        $data = [
            'selectedDate' => '',
            'selectedCategory' => 0,
            'categories' => $categories,
            'amounts' => [],
            'totalSales' => ['sale2' => 0, 'sale1' => 0, 'sale0' => 0, 'relation0vs1' => 0, 'relation0vs2' => 0],
            'totalPurchase' => ['purchase2' => 0, 'purchase1' => 0, 'purchase0' => 0,
                'purchaseRelation2' => 0, 'purchaseRelation1' => 0,],
            'year' => ['2' => '', '1' => '', '0' => ''],

        ];

        if ($request->all() != []) {

            $request->validate([
                'dates' => ['required'],
                'category' => ['required', 'not_in:Departamento'],
            ]);
            $inputCategory = $request->input('category');
            $inputDates = $request->input('dates');

            $category = Category::findOrFail($inputCategory);
            if ($inputDates != '' && $inputDates != 0) {
                $dates = array_map('trim', explode('to', $inputDates));
                if (count($dates) == 1) {
                    $dates[] = $dates[0];
                }
            }

            $date1 = Carbon::createFromFormat('Y-m-d', $dates[0])->setTime(0, 0, 0)->subYear(2);
            $date2 = Carbon::createFromFormat('Y-m-d', $dates[1])->setTime(0, 0, 0);

            $year['2'] = Carbon::createFromFormat('Y-m-d', $dates[0])->setTime(0, 0, 0)->subYear(2)->year;
            $year['1'] = Carbon::createFromFormat('Y-m-d', $dates[0])->setTime(0, 0, 0)->subYear(1)->year;
            $year['0'] = Carbon::createFromFormat('Y-m-d', $dates[0])->setTime(0, 0, 0)->year;

            $query = "
            EXEC dbo.DRGetFamilySalesOverYears @From = '{$date1}', @To = '{$date2}', @Category = {$category->CategoryId}
            ";
            $queryResults = DB::connection('mssql')->selectResultSets($query);

            // Resultados de Ventas
            $results = collect($queryResults[0]);
            // Resultado de compras
            $familyPurchaseResults = collect($queryResults[1]);


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
            }, ['sale2' => 0, 'sale1' => 0, 'sale0' => 0]);

            $totalPurchase = $familyPurchaseResults->reduce(function ($carry, $item) use ($totalSales) {
                $purchase0 = $carry['purchase0'] + $item->purchase0;
                $purchase1 = $carry['purchase1'] + $item->purchase1;
                $purchase2 = $carry['purchase2'] + $item->purchase2;
                $purchaseRelation1 = $purchase1 != 0 ? $purchase0 / $purchase1 * 100 : 0;
                $purchaseRelation2 = $purchase2 != 0 ? $purchase0 / $purchase2 * 100 : 0;

                return collect([
                    'purchase2' => $purchase2,
                    'purchase1' => $purchase1,
                    'purchase0' => $purchase0,
                    'purchaseRelation2' => $purchaseRelation2,
                    'purchaseRelation1' => $purchaseRelation1,
                ]);
            }, ['purchase2' => 0, 'purchase1' => 0, 'purchase0' => 0]);

            $totalPurchaseFormatted = collect($totalPurchase)->map(function ($value) {
                return number_format($value, 0); // Formatea cada valor
            });

            $totalSalesFormatted = collect($totalSales)->map(function ($value) {
                return number_format($value, 0); // Formatea cada valor
            });

            $amounts = $results->map(function ($row) use ($familyPurchaseResults) {
                $purchase = $familyPurchaseResults->where('familyid', $row->FamilyId)->first();
                $purchaseRelation0vs1 = $purchase->purchase1 != 0 ? $purchase->purchase0 / $purchase->purchase1 * 100 : 0;
                $purchaseRelation0vs2 = $purchase->purchase2 != 0 ? $purchase->purchase0 / $purchase->purchase2 * 100 : 0;

                $relation0vs1 = $row->sale1 != 0 ? $row->sale0 / $row->sale1 * 100 : 0;
                $relation0vs2 = $row->sale2 != 0 ? $row->sale0 / $row->sale2 * 100 : 0;
                return collect([
                    'familyid' => $row->FamilyId,
                    'name' => $row->Name,
                    'sale2' => number_format($row->sale2, 0),
                    'sale1' => number_format($row->sale1, 0),
                    'sale0' => number_format($row->sale0, 0),
                    'relation0vs1' => number_format($relation0vs1, 0),
                    'relation0vs2' => number_format($relation0vs2, 0),
                    'purchaseRelation0vs1' => number_format($purchaseRelation0vs1, 0),
                    'purchaseRelation0vs2' => number_format($purchaseRelation0vs2, 0),
                    'purchase2' => number_format($purchase->purchase2, 0),
                    'purchase1' => number_format($purchase->purchase1, 0),
                    'purchase0' => number_format($purchase->purchase0, 0),
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
                'year' => $year,
            ];

        }


        return view('salesYoy.index', $data);


    }

}
