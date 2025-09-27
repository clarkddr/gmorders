<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchMaxMin;
use App\Models\Color;
use App\Models\Maxmin;
use App\Services\MaxMin\MaxMinService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreMaxminRequest;

class MaxminController extends Controller
{
    public function index(Request $request){
        $branches = Branch::whereNotIn('BranchId',[4,5,10,14])->get();
        $selectedDate = Carbon::now()->startOfYear();
        $maxmins = app(MaxMinService::class)->getMaxminPzByBranch($selectedDate);
        $data = [
            'branches' => $branches,
            'selectedDate1' => $selectedDate,
            'maxmins' => $maxmins
        ];
        if($request->all() == []){
            return view('maxmin.index',$data);
        }


        $request->validate([
            'date' => 'date',
            'branch' => 'required|numeric',
        ]);




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
            'min' => 'numeric',
            'max' => 'numeric',
        ]);

        $maxmin = MaxMin::where([
            'code' => $request['code'],
            'SupplierId' => $request['supplierid'],
            'Subcategoryid' => $request['subcategoryid'],
            'Colorid' => $request['colorid'],
        ])->first();

        if($maxmin){
            return redirect()->back()->with('banner',['type' => 'warning','message' => 'El Máximo/Mínimo ya existe.']);
        }

        $color = Color::find($request->colorid) ?? 'Sin Color';

        $branches = Branch::whereNotIn('BranchId',[4,5,10,14])->get();

        $data = [
            'branches' => $branches,
            'colorName' => $color->ColorName
        ];

        return view('maxmin.create',$data);

    }

    public function store(StoreMaxminRequest $request){
        $validated = $request->validated();
        $maxmin = [
            'code' => $validated['code'],
            'SupplierId' => $validated['supplierid'],
            'Subcategoryid' => $validated['subcategoryid'],
            'Colorid' => $validated['colorid'],
            'pack_quantity' => $validated['pack_quantity']
        ];

        $maxminExists = MaxMin::where([
            'code' => $validated['code'],
            'SupplierId' => $validated['supplierid'],
            'Subcategoryid' => $validated['subcategoryid'],
            'Colorid' => $validated['colorid'],
        ])->first();

        if($maxminExists) return redirect()->route('maxmin.index')->with('banner',['type' => 'warning','message' => 'Ocurrió un error, el Máximo/Mínimo ya existe.']);

        $maxmin = MaxMin::create($maxmin);

        $rows = [];

        foreach ($validated['branches'] as $branch => $row) {
            $min = $row['min'] ?? null;
            $max = $row['max'] ?? null;
            if ($min === null && $max === null ) continue;

            $rows[] = [
                'branch_id' => $branch,
                'maxmin_id' => $maxmin->id,
                'min' => $min,
                'max' => $max,
            ];
        }
        if ($rows) {
            BranchMaxmin::upsert($rows, ['maxmin_id','branch_id'], ['min','max']);
        }
        return redirect()->route('maxmin.index')->with('banner',['type' => 'success','message' => 'El Mínimo-Máximo se ha creado correctamente.']);

    }

    public function edit(Maxmin $maxmin){
        $maxmin = $maxmin->load(['color','branches.branch']);
        $branches = Branch::whereNotIn('BranchId',[4,5,10,14])->get();
        $data = [
            'maxmin' => $maxmin,
            'branches' => $branches
        ];


        return view('maxmin.edit',$data);
    }

    public function update(StoreMaxminRequest $request,     Maxmin $maxmin){
        $data = $request->validated();

        $toIntOrNull = fn($v) => ($v === '' || $v === null) ? null : (int) $v;

        // 1) Padre
        if (array_key_exists('pack_quantity', $data)) {
            $maxmin->pack_quantity = $toIntOrNull($data['pack_quantity']);
            $maxmin->save();
        }

        // 2) Sucursales
        foreach ($data['branches'] ?? [] as $branchId => $vals) {
            $minRaw = $vals['min'] ?? null;
            $maxRaw = $vals['max'] ?? null;

            $minEmpty = ($minRaw === '' || $minRaw === null);
            $maxEmpty = ($maxRaw === '' || $maxRaw === null);

            // (A) Si ambos vacíos → NO crear/actualizar; si existía, bórralo
            if ($minEmpty && $maxEmpty) {
                $maxmin->branches()
                    ->where('branch_id', (int)$branchId)
                    ->delete();
                continue;
            }

            // (B) Si uno viene y el otro no → política: falla validación
            if ($minEmpty xor $maxEmpty) {
                return back()->withErrors([
                    "branches.$branchId.min" => 'Debes capturar MÍNIMO y MÁXIMO juntos o dejar ambos vacíos.',
                    "branches.$branchId.max" => 'Debes capturar MÍNIMO y MÁXIMO juntos o dejar ambos vacíos.',
                ])->withInput();
            }

            // (C) Ambos vienen con número → upsert
            $payload = [
                'min' => (int)$minRaw,
                'max' => (int)$maxRaw,
            ];

            $maxmin->branches()->updateOrCreate(
                ['maxmin_id' => $maxmin->id, 'branch_id' => (int)$branchId],
                $payload
            );
        }

        // 3) Limpieza opcional: si llegaron branches, elimina los que no vinieron
        if (!empty($data['branches'])) {
            $incoming = collect($data['branches'])->keys()->map(fn($id)=>(int)$id);
            $maxmin->branches()->whereNotIn('branch_id', $incoming)->delete();
        }

        return redirect()->route('maxmin.index')->with('banner',['type' => 'success','message' => 'El Máximo/Mínimo se ha actualizado correctamente.']);
    }

    public function destroy(Maxmin $maxmin){
        $maxmin->forceDelete();
        return redirect()->route('maxmin.index')->with('banner',['type' => 'success','message' => 'El Máximo/Mínimo se ha eliminado correctamente.']);
    }

    public function archive(Maxmin $maxmin){
        $maxmin->delete();
        return redirect()->route('maxmin.index')->with('banner',['type' => 'success','message' => 'El Máximo/Mínimo se ha archivado correctamente.']);
    }
}
