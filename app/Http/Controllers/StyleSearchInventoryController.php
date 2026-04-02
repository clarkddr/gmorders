<?php

namespace App\Http\Controllers;

use App\Models\BranchSalesTarget;
use Illuminate\Http\Request;
use App\Repositories\StyleSearchInventory\StyleSearchInventoryRepository;
use Inertia\Inertia;

class StyleSearchInventoryController extends Controller
{
    public function index(String $slug,Request $request, StyleSearchInventoryRepository $styleSearchInventoryRepository){
        $branch = BranchSalesTarget::where('slug', $slug)->first();
        $branchid = $branch->branch_id ?? 0;
        $branchName = $branch->branch->Name ?? '';
        $query = $request->query('query','');

        $styles = $styleSearchInventoryRepository->fetchData($query,$branchid);
        return Inertia::render('StyleSearchInventory/Search',[
            'styles' => $styles,
            'filters' => ['query' => $query],
            'slug' => $slug,
            'branchName' => $branchName
        ]);

    }
}
