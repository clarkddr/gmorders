<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Family;
use App\Models\Projection;
use App\Models\ProjectionAmount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectionController extends Controller
{

    public function index()
    {
    $projections = Projection::paginate(10);

    $data = [
        'projections' => $projections
    ];

    return view('projection.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function amounts(Request $request)
    {
        $projection = Projection::find($request->projectionid);
        $family = Family::find($request->familyid);
        $branches = Branch::whereNotIn('BranchId',[4,5,10,14])->get();
        $data = [
            'projection' => $projection,
            'family' => $family,
            'branches' => $branches,
            'amounts' => [],
        ];
        $initDate = $projection->start;
        $finalDate = $projection->end;
        // Se sacan las fechas para los dos ciclos
        $yearBeforeLastInitialDate = Carbon::createFromFormat('Y-m-d H:i:s', $initDate)->setTime(0,0,0)->subYear(2);
        $yearBeforeLastFinalDate = Carbon::createFromFormat('Y-m-d H:i:s', $finalDate)->setTime(0,0,0)->subYear(2);
        $yearLastInitialDate = Carbon::createFromFormat('Y-m-d H:i:s', $initDate)->setTime(0,0,0)->subYear(1);
        $yearLastFinalDate = Carbon::createFromFormat('Y-m-d H:i:s', $finalDate)->setTime(0,0,0)->subYear(1);

        // Se consiguen los ProjectionAmount guardados de la familia
        $projectionAmounts = ProjectionAmount::where('projection_id', $projection->id)->where('FamilyId', $family->FamilyId)->get();

        // Se ejecuta el primer reporte de hace dos anios
        $query = "
        EXEC dbo.DRGetSalesReportByFamily @From = '{$yearBeforeLastInitialDate}', @To = '{$yearBeforeLastFinalDate}', @Category = 0, @Family = {$family->FamilyId}
        ";
        $queryResults = DB::connection('mssql')->selectResultSets($query);
        $yearBeforeLastSaleResults = collect($queryResults[0]);
        $yearBeforeLastPurchaseResults = collect($queryResults[1]);
        // Totales
        $yearBeforeLastSaleTotals = collect($queryResults[4]);
        $yearBeforeLastPurchaseTotals = collect($queryResults[5]);


        // Se ejecuta el reporte del anio anterior
        $query2 = "
        EXEC dbo.DRGetSalesReportByFamily @From = '{$yearLastInitialDate}', @To = '{$yearLastFinalDate}', @Category = 0, @Family = {$family->FamilyId}
        ";
        $queryResults2 = DB::connection('mssql')->selectResultSets($query2);
        $yearLastSaleResults = collect($queryResults2[0]);
        $yearLastPurchaseResults = collect($queryResults2[1]);
        // Totales
        $yearLastSaleTotals = collect($queryResults2[4]);
        $yearLastPurchaseTotals = collect($queryResults2[5]);

        $yearBeforeLast_relation = 0;
        $yearLast_relation = 0;
        $projection_relation = 0;
        // Se calculan las relaciones
        $yearBeforeLastpurchaseSum = $yearBeforeLastPurchaseTotals->sum('Venta');
        if(isset($yearBeforeLastpurchaseSum) && $yearBeforeLastpurchaseSum != 0){
            $yearBeforeLast_relation = $yearBeforeLastSaleTotals->sum('Current') / $yearBeforeLastPurchaseTotals->sum('Venta') * 100;
        }
        $yearLastpurchaseSum = $yearLastPurchaseTotals->sum('Venta');
        if(isset($yearLastpurchaseSum) && $yearLastpurchaseSum != 0){
            $yearLast_relation = $yearLastSaleTotals->sum('Current') / $yearLastPurchaseTotals->sum('Venta') * 100;
        }
        $projectionPurchaseSum = $projectionAmounts->sum('purchase');
        if($projectionPurchaseSum != 0){
            $projection_relation = $projectionAmounts->sum('new_sale') / ($projectionAmounts->sum('purchase') *3) * 100;
        }



        // Se integran los totales
        $totalAmounts = collect([
            'yearBeforeLast_new_sale' => number_format($yearBeforeLastSaleTotals->sum('Current'),0) ?? 0,
            'yearBeforeLast_old_sale' => number_format($yearBeforeLastSaleTotals->sum('Old'),0) ?? 0,
            'yearBeforeLast_purchase_cost' => number_format($yearBeforeLastPurchaseTotals->sum('Costo'),0) ?? 0,
            'yearBeforeLast_purchase_sale' => number_format($yearBeforeLastPurchaseTotals->sum('Venta'),0) ?? 0,
            'yearBeforeLast_relation' => number_format($yearBeforeLast_relation,0) ?? 0,
            'yearLast_new_sale' => number_format($yearLastSaleTotals->sum('Current'),0) ?? 0,
            'yearLast_old_sale' => number_format($yearLastSaleTotals->sum('Old'),0) ?? 0,
            'yearLast_purchase_cost' => number_format($yearLastPurchaseTotals->sum('Costo'),0) ?? 0,
            'yearLast_purchase_sale' => number_format($yearLastPurchaseTotals->sum('Venta'),0) ?? 0,
            'yearLast_relation' => number_format($yearLast_relation,0) ?? 0,
            'projection_new_sale' => number_format($projectionAmounts->sum('new_sale'),0) ?? 0,
            'projection_old_sale' => number_format($projectionAmounts->sum('old_sale'),0) ?? 0,
            'projection_purchase' => number_format($projectionAmounts->sum('purchase'),0) ?? 0,
            'projection_relation' => number_format($projection_relation,0) ?? 0
        ]);

        // Se integra todo a la tabla Branches
        $amounts = $branches->map(
            function ($branch) use ($yearBeforeLastSaleResults, $yearBeforeLastPurchaseResults, $yearLastSaleResults, $yearLastPurchaseResults,$projectionAmounts) {
                $yearBeforeLastSale = collect($yearBeforeLastSaleResults->where('branchid', $branch->BranchId)->first());
                $yearBeforeLastPurchase = collect($yearBeforeLastPurchaseResults->where('branchid', $branch->BranchId)->first());
                $yearLastSale = collect($yearLastSaleResults->where('branchid', $branch->BranchId)->first());
                $yearLastPurchase = collect($yearLastPurchaseResults->where('branchid', $branch->BranchId)->first());
                $projectionAmounts = $projectionAmounts->where('BranchId', $branch->BranchId)->first();

                return collect([
                    'branchid' => $branch->BranchId,
                    'name' => $branch->Name,
                    'current_year' => [
                        'projection_amount_id' => $projectionAmounts->id ?? null,
                        'old_sale' => number_format($projectionAmounts->old_sale ?? 0,0),
                        'new_sale' => number_format($projectionAmounts->new_sale ?? 0,0),
                        'total_sale' => number_format($projectionAmounts->total_sale ?? 0,0),
                        'purchase_cost' => number_format($projectionAmounts->purchase ?? 0,0),
                        'relation' => isset($projectionAmounts->new_sale, $projectionAmounts->purchase) && $projectionAmounts->purchase != 0
                        ? number_format($projectionAmounts->new_sale / ($projectionAmounts->purchase * 3 ) * 100, 0) : 0,
                    ],
                    'beforelast_year' => [
                        'old_sale' => number_format($yearBeforeLastSale['Old'] ?? 0,0),
                        'new_sale' => number_format($yearBeforeLastSale['Current'] ?? 0,0),
                        'total_sale' => number_format($yearBeforeLastSale['Amount'] ?? 0,0),
                        'purchase_cost' => number_format($yearBeforeLastPurchase['Costo'] ?? 0,0),
                        'purchase_sale' => number_format($yearBeforeLastPurchase['Venta'] ?? 0,0),
                        'relation' => isset($yearBeforeLastSale['Current'], $yearBeforeLastPurchase['Venta']) && $yearBeforeLastPurchase['Venta'] != 0
                        ? number_format($yearBeforeLastSale['Current'] / $yearBeforeLastPurchase['Venta'] * 100, 0) : 0
                    ],
                    'last_year' => [
                        'old_sale' => number_format($yearLastSale['Old'] ?? 0,0),
                        'new_sale' => number_format($yearLastSale['Current'] ?? 0,0),
                        'total_sale' => number_format($yearLastSale['Amount'] ?? 0,0),
                        'purchase_cost' => number_format($yearLastPurchase['Costo'] ?? 0,0),
                        'purchase_sale' => number_format($yearLastPurchase['Venta'] ?? 0,0),
                        'relation' => isset($yearLastSale['Current'], $yearLastPurchase['Venta']) && $yearLastPurchase['Venta'] != 0
                        ? number_format($yearLastSale['Current'] / $yearLastPurchase['Venta'] * 100, 0) : 0
                    ],
                ]);
            }
        );

        $data['amounts'] = $amounts;
        $data['beforelast_year'] = $yearBeforeLastInitialDate->year;
        $data['last_year'] =$yearLastInitialDate->year;
        $data['total'] = $totalAmounts;
// dd($data);

        return view('projection.amounts',$data);

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
        $projection = Projection::find($id);
        $categoryList = collect(Category::with('families')->whereIn('CategoryId',[1,4,12,2])->get());
        $categories = Family::with('category')->get();
        $families = Family::all();

        $projectionAmounts = ProjectionAmount::where('projection_id',$id)->get();
        $totals = collect([
            'sale' => $projectionAmounts->sum('new_sale') + $projectionAmounts->sum('old_sale'),
            'purchase' => $projectionAmounts->sum('purchase'),
        ]);
        $totals->put('purchaseVsSale', $totals['sale'] > 0 ? ($totals['purchase'] / $totals['sale'] * 100) : 0);

        $totalsFormatted = collect([
            'sale' => number_format($totals['sale'],0),
            'purchase' => number_format($totals['purchase'],0),
            'purchaseVsSale' => number_format($totals['purchaseVsSale'],0),
        ]);

        $totalesPorCategoria = $projectionAmounts->reduce(function ($carry, $item) use ($categories) {
            $family = $categories->firstWhere('FamilyId', $item['FamilyId']);

            if (!$family) {
                return $carry; // Si no encuentra la familia, pasa al siguiente
            }
            $category = $family->category->first() ?? null;
            if (!$category) {
                return $carry; // Si la categoría es null, omite este registro
            }
            if (!isset($carry[$category->CategoryId])) {
                $carry[$category->CategoryId] = [
                    'CategoryId' => $category->CategoryId,
                    'Name' => $category->Name,
                    'total_sale' => 0,
                    'total_purchase' => 0,
                ];
            }
            $carry[$category->CategoryId]['total_sale'] += $item['new_sale'] + $item['old_sale'];
            $carry[$category->CategoryId]['total_purchase'] += $item['purchase'];

            return $carry;
        }, []);

        $totalsByCategory = collect($totalesPorCategoria);

        $totalesPorFamilia = $projectionAmounts->reduce(function ($carry, $item) use ($families) {
            $key = $item['FamilyId']; // Creamos una clave única para FamilyId y CategoryId combinados
            $family = $families->where('FamilyId', $item['FamilyId'])->first();
            // Si no existe la clave en el acumulador, inicializamos los valores
            if (!isset($carry[$key])) {
                $carry[$key] = [
                    'FamilyId' => $family->FamilyId,
                    'total_sale' => 0,
                    'total_purchase' => 0,
                ];
            }
            // Acumulamos los valores de new_sale y old_sale para cada combinación de FamilyId y CategoryId
            $carry[$key]['total_sale'] += $item['new_sale'] + $item['old_sale'];
            $carry[$key]['total_purchase'] += $item['purchase'];
            return $carry;
        }, []);
        // Convertimos el resultado en una colección si necesitas manipularlo posteriormente
        $projectiontotalsPerFamily = collect($totalesPorFamilia);


        $familyListWithData = $categoryList->map(function ($category) use ($projectiontotalsPerFamily,$totalsByCategory,$projection) {
            $sale = $totalsByCategory->where('CategoryId', $category->CategoryId)->sum('total_sale');
            $purchase = $totalsByCategory->where('CategoryId', $category->CategoryId)->sum('total_purchase');
            $relation = $sale !=0 ? (float)$purchase/$sale *100: 0;
            return [
                'CategoryId' => $category->CategoryId,
                'Name' => $category->Name,
                'sale' => number_format($sale,0),
                'purchase' => number_format($purchase,0),
                'relation' => number_format($relation,0),
                'families' => $category->families->map(function ($family) use ($projectiontotalsPerFamily,$projection) {
                    $has_projection = ProjectionAmount::where('projection_id',$projection->id)->where('FamilyId', $family->FamilyId)->exists();
                    $total_sale = $projectiontotalsPerFamily->where('FamilyId', $family->FamilyId)->sum('total_sale');
                    $total_purchase = $projectiontotalsPerFamily->where('FamilyId', $family->FamilyId)->sum('total_purchase');
                    $relation = $total_sale !=0 ? (float)$total_purchase/$total_sale *100: 0;
                    return [
                        'FamilyId' => $family->FamilyId,
                        'Name' => $family->Name,
                        'total_sale' => number_format($total_sale,0),
                        'total_purchase' => number_format($total_purchase,0),
                        'relation' => number_format($relation,0),
                        'has_projection' => $has_projection
                    ];
                }),
            ];
        });

        $familyData = collect($familyListWithData);

        $data = [
            'totals' => $totalsFormatted,
            'categories' => $familyData,
            'projection' => $projection,
        ];

        return view('projection.edit', $data);
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
