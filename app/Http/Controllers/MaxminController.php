<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Maxmin;
use App\Services\MaxMin\MaxMinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaxminController extends Controller
{
    public function index(Request $request){
        $maxmins = MaxMin::with(['supplier','family','color','subcategory','branches'])
            ->withSum('branches as total_max', 'max')
            ->withSum('branches as total_min', 'min')
            ->get();
        $data = [
            'selectedDate1' => '',
            'maxmins' => $maxmins
        ];
        return view('maxmin.index',$data);
    }

    public function search(Request $request){

        if ($request->all() == []) {
            return view('maxmin.search',['branches' => []]);
        }

        $request->validate([
            'code' => 'required'
        ]);


        $code = request('code');

        $codes = app(MaxMinService::class)->search($code);


        return view('maxmin.search',[
            'codes' => $codes,
        ]);
    }

    public function create(Request $request){
        $request->validate([
            'max' => 'numeric',
        ]);
        $branches = Branch::whereNotIn('BranchId',[4,5,10,14])->get();
        $data = [
            'branches' => $branches
        ];

        return view('maxmin.create',$data);

    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'branches' => ['required','array'],
            'branches.*.min' => ['nullable','numeric','gte:0'],
            'branches.*.max' => ['nullable','numeric','gte:0'],
        ]);

        $validator->after(function ($validator) use ($request) {
            foreach($request->input('branches',[]) as $branch => $row){
                $min = $row['min'] ?? null;
                $max = $row['max'] ?? null;

                if( ($min === null && $max !== null) || ($min !== null && $max === null) ){
                    $faltante = $min === null ? 'min' : 'max';
                    $validator->errors()->add("branches.{$branch}.{$faltante}", "El campo {$faltante} es requerido");
                }

                if ($min !== null && $max !== null && $max <= $min) {
                    $validator->errors()->add("branches.{$branch}.max", 'El máximo debe ser mayor que el mínimo.');
                }
            }

        });
        $validated = $validator->validate();






    }
}
