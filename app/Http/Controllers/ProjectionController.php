<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Family;
use App\Models\Projection;
use App\Models\ProjectionAmount;
use App\Models\Subcategory;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\DB;

class ProjectionController extends Controller
{

    public function index()
    {     
    $projections = Projection::all();  
    $data = [
        'projections' => $projections
    ];

    return view('projection.index', $data);   
        
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}
