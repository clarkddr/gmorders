<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\StyleSearch\StyleSearchRepository;

class StyleSearchController extends Controller
{
    public function index(Request $request, StyleSearchRepository $styleSearchRepository){
        $query = $request->query('query','');
        $styles = $styleSearchRepository->getData($query);

        return Inertia::render('StyleSearch/Search',[
            'styles' => $styles,
            'filters' => ['query' => $query],
            'slug' => $request->query('slug')
        ]);

    }
}
