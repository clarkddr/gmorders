<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Family;
use App\Models\ProjectionMonth;
use Illuminate\Http\Request;

class ProjectionMonthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::with('families')->whereIn('CategoryId',[1,2,4,12])->get();
        $percentages = ProjectionMonth::where('projection_id',$request->id)->get();

        $data = [
            'categories' => $categories,
            'percentages' => $percentages
        ];
        return view('projectionMonth.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectionMonth $projectionMonth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectionMonth $projectionMonth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectionMonth $projectionMonth)
    {
        //
    }
}
