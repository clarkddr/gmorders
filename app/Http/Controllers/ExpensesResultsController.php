<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Branch;
use App\Models\Category;
use App\Services\ExpensesResults\ExpensesResultsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpensesResultsController extends Controller
{
    public function index(Request $request){

        $categories = Category::whereIn('CategoryId',[1,4,12])->get();
        $branches = Branch::isActive()->get();

        $familiesList = Category::with('families')->whereIn('CategoryId',[1,2,4,12])->get();
        $dates = DateHelper::getDefaultDateRanges();
        $data = [
            'selectedDate1' => '',
            'dates' => $dates,
            'expenses' => [],
            'year' => '2025',
        ];


        if ($request->all() == []) {
            return view('expensesResults.index', $data);
        }

        $request->validate([
            'dates1' => 'required',
        ]);


        $inputDates1 = $request->input('dates1');
        [$fromDate1, $toDate1] = DateHelper::parseDateRange($inputDates1);
        $year = Carbon::parse($fromDate1)->format('Y');
        $expenses = app(ExpensesResultsService::class)->getData($fromDate1,$toDate1);
        $data['expenses'] = $expenses;
        $data['year'] = $year;


        return view('expensesResults.index',$data);
    }
}
