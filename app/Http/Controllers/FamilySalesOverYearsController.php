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
            'sales' => [],
            'totalSales' => ['sale2' => 0, 'sale1' => 0, 'sale0' => 0],
        ];
        
        return view('salesYoy.index',$data);
    }

    public function show(Request $request){
        $request->validate([
           'dates' => ['required'],
           'category' => ['required'], 
        ]);


        $categories = Category::whereIn('CategoryId',[1,4,12])->get();
        $category = Category::find($request->input('category'));
        $dates = array_map('trim', explode('to', $request->input('dates')));
        if(count($dates) == 1){
            $dates[] = $dates[0];
        }

        $date1 = Carbon::createFromFormat('Y-m-d', $dates[0])->subYear(2);
        $date2 = Carbon::createFromFormat('Y-m-d', $dates[1]);

        $query = "
        EXEC dbo.DRGetFamilySalesOverYears @From = '{$date1}', @To = '{$date2}', @Category = {$category->CategoryId}
        ";
        // $queryResults = [];
        $queryResults = DB::connection('mssql')->selectResultSets($query);
        $results = collect($queryResults[0]);


        $totalSales = $results->reduce(function ($carry, $item) {
            return collect([
                'sale2' => $carry['sale2'] + $item->sale2,
                'sale1' => $carry['sale1'] + $item->sale1,
                'sale0' => $carry['sale0'] + $item->sale0,
            ]);    
        },['sale2' => 0, 'sale1' => 0, 'sale0' => 0]);
        
        $totalSalesFormatted = collect($totalSales)->map(function ($value) {
            return number_format($value, 0); // Formatea cada valor
        });

        $sales = $results->map(function ($row) {            
           return collect([
               'familyid' => $row->FamilyId,
               'name' => $row->Name,
               'sale2' => number_format($row->sale2,0),
               'sale1' => number_format($row->sale1,0),
               'sale0' => number_format($row->sale0,0),
               'sale0_float' => $row->sale0,
            ]); 
        });        
        
        $data = [
            'selectedDate' => $request->input('dates'),
            'selectedCategory' => $category,
            'categories' => $categories,
            'sales' => $sales,
            'totalSales' => $totalSalesFormatted,
        ];

        return view('salesYoy.index',$data);

        
    }
}
