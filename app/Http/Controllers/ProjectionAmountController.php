<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Family;
use App\Models\Projection;
use App\Models\ProjectionAmount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use function Laravel\Prompts\select;

class ProjectionAmountController extends Controller
{

    public function index(Request $request)
    {
        $projectionList = Projection::latest()->get();

        $data = [
            'projectionList' => $projectionList,
            'thisYearSales' => collect([]),
            'categories' => collect([]),
            'selectedProjection' => [
                'id' => 0,
                'name' => null,
                'start' => null,
                'end' => null
            ]
        ];
        function addPositionsToCollection($data)
        {
            $total = $data->sum('value');

            // Calcular el porcentaje para cada elemento
            $dataWithPercentage = $data->map(function($item) use ($total) {
                return [
                    'name' => $item['name'],
                    'value' => $item['value'],
                    'percentage' => $item['value'] / $total
                ];
            });

            // Obtener el máximo y mínimo de los porcentajes
            $max = $dataWithPercentage->max('percentage');
            $min = $dataWithPercentage->min('percentage');

            // Calcular el valor de escala, dividiendo entre 7 posiciones
            $scale = ($max - $min) / 7;

            // Calcular las posiciones basadas en 7 divisiones
            $positions = [];
            for ($i = 1; $i <= 7; $i++) {
                $positions[] = $min + ($i * $scale); // Ajuste para empezar desde el mínimo
            }

            // Asignar 'position' basado en los porcentajes y posiciones calculadas
            $dataWithPercentage = $dataWithPercentage->map(function($item) use ($positions) {
                $assigned = false;

                foreach ($positions as $index => $position) {
                    if ($item['percentage'] <= $position) {
                        // Guardar el índice como 'position'
                        $item['position'] = $index + 1; // +1 para reflejar la posición
                        $assigned = true;
                        break;
                    }
                }

                // Si no se ha asignado una posición, asignar la última posición (7)
                if (!$assigned) {
                    $item['position'] = 7;
                }

                return $item;
            });

            return $dataWithPercentage;
        }

            if($request->all() != []) {
                $request->validate([
                    'projection' => ['required','not_in:0'],
                ]);

                // Falta agregar las siguientes columnas
                /* Avance de lo Real vs Una nueva estimacion que seria:
                    - Sacar la relacion entre venta total proyectada y total año anterior (Meta)
                    - Aumentar esa Meta a la venta al dia del año pasado
                    - Relacion entre la venta al dia del año actual vs Meta al dia (Mostrarlo como boton de Color)
                */

                $selectedProjection = Projection::findOrFail($request->projection);
                $projectionamounts = $selectedProjection->projectionamounts()->get();
                $families = Family::all();
                $categories = Category::with('families')->whereIn('CategoryId',[1,2,4,12])->get();
                $projectionResults = $projectionamounts
                    ->groupBy('FamilyId')
                    ->map(function ($familyGroup) use ($categories, $families) {
                        $family = $familyGroup->first();
                        // Encontramos la categoría asociada
                        $category = $categories->first(function ($category) use ($family) {
                            return $category->families->contains('FamilyId', $family->FamilyId);
                        });

                        // Encontramos el modelo de la familia
                        $familyModel = $families->firstWhere('FamilyId', $family->FamilyId);

                        // Sumamos los valores de la familia considerando todos los registros del grupo
                        $current = $familyGroup->sum('new_sale');
                        $old = $familyGroup->sum('old_sale');
                        $purchase = $familyGroup->sum('purchase');
                        $total = $current + $old;

                        // Retornamos los resultados formateados
                        return collect([
                            'categoryid' => $category ? $category->CategoryId : 0,
                            'categoryName' => $category ? $category->Name : 'Sin Categoria',
                            'familyid' => $family->FamilyId,
                            'familyName' => $familyModel ? $familyModel->Name : 'Sin Nombre',
                            'current' => $current,
                            'old' => $old,
                            'total' => $total,
                            'purchase' => $purchase
                        ]);
                    });
                $lastYearStart = Carbon::parse($selectedProjection->start)->subYear();
                $lastYearEnd = Carbon::parse($selectedProjection->end)->subYear();
                $yesterdayLastYear = Carbon::yesterday()->subYear();
                // Si el dia de ayer del año anterior se pasa del ultimo dia del periodo, entonces retorna el ultimo dia del periodo.
                $yesterdayLastYear = $yesterdayLastYear->greaterThan($lastYearEnd) ? $lastYearEnd : $yesterdayLastYear;


                // Se sacan ventas del año anterior al periodo completo seleccionado, para sacar el total y compararlo con la proyeccion
                $lastYearQueryWholePeriod = "
                EXEC dbo.DRGetSalesReportByFamily @From = '{$lastYearStart->format('Y-m-d')}', @To = '{$lastYearEnd->format('Y-m-d')}', @Family = 0, @Category = 0
                ";
                $lastYearQueryResultsPeriod = DB::connection('mssql')->selectResultSets($lastYearQueryWholePeriod);
                $lastYearSaleResults = collect($lastYearQueryResultsPeriod[2]);

                // Se sacan ventas del año anterior al periodo pero de un dia antes, no periodo completo para ver el avance
                $lastYearQueryPartialPeriod = "
                EXEC dbo.DRGetSalesReportByFamily @From =
                '{$lastYearStart->format('Y-m-d')}', @To = '{$yesterdayLastYear->format('Y-m-d')}',
                 @Family = 0, @Category = 0
                ";
                $lastYearQueryResultsPartial = DB::connection('mssql')->selectResultSets($lastYearQueryPartialPeriod);
                $lastYearPartialSaleResults = collect($lastYearQueryResultsPartial[2]);


                $categoriesGoalSale = $categories->map(function ($category) use ($lastYearPartialSaleResults,$lastYearSaleResults,$projectionResults) {
                       $lastYearSaleCategory = $lastYearSaleResults->where('CategoryId', $category->CategoryId)->sum('Amount');
                       $projectionCategory = $projectionResults->where('categoryid', $category->CategoryId)->sum('total');
                       $categoryRelationGoal = $lastYearSaleCategory > 0 ? $projectionCategory/$lastYearSaleCategory : 0;
                       $lastYearPartialSaleCategory = $lastYearPartialSaleResults->where('CategoryId', $category->CategoryId)->sum('Amount');
                       $partialGoalSaleCategory = $categoryRelationGoal * $lastYearPartialSaleCategory;
                   return collect([
                       'categoryId' => $category->CategoryId,
                       'lastYearSaleCategory' => number_format($lastYearSaleCategory,0), // 21,529,083
                       'projectionCategory' => number_format($projectionCategory,0), //23,237,491
                       'categoryRelationGoal' => $categoryRelationGoal, //23,237,491/21,529,083 = 1.07935349592
                       'lastYearPartialSaleCategory' => number_format($lastYearPartialSaleCategory,0), // 708,079
                       'categoryPartialGoal' => $partialGoalSaleCategory // 708,079 * 1.07935349592 = 764,267.54
                   ]);
                });

                $familiesGoalSale = $categories->flatMap(function ($category) use ($lastYearPartialSaleResults,$lastYearSaleResults,$projectionResults) {
                    return $category->families->map(function ($family) use ($lastYearPartialSaleResults, $lastYearSaleResults, $projectionResults) {
                        $lastYearSaleFamily = $lastYearSaleResults->where('FamilyId', $family->FamilyId)->sum('Amount');
                        $projectionFamily = $projectionResults->where('familyid', $family->FamilyId)->sum('total');
                        $familyRelationGoal = $lastYearSaleFamily > 0 ? $projectionFamily/$lastYearSaleFamily : 0;
                        $lastYearPartialSaleFamily = $lastYearPartialSaleResults->where('FamilyId', $family->FamilyId)->sum('Amount');
                        $partialGoalSaleFamily = $familyRelationGoal * $lastYearPartialSaleFamily;
                        return collect([
                            'familyId' => $family->FamilyId,
                            'familyName' => $family->Name,
                            'lastYearSaleFamily' => $lastYearSaleFamily, // 5,940,672
                            'projectionFamily' => $projectionFamily,    // 6,479,291
                            'familyRelationGoal' => $familyRelationGoal,// 6,479,291/5,940,672 = 1.0906
                            'lastYearPartialSaleFamily' => $lastYearPartialSaleFamily, // 109,892
                            'partialGoalSaleFamily' => $partialGoalSaleFamily // 119,848
                        ]);
                    });
                });

                // Se sacan ventas y compras del periodo seleccionado, para ir viendo avance al dia
                $thisYearQquery = "
                EXEC dbo.DRGetSalesReportByFamily @From = '{$selectedProjection->start}', @To = '{$selectedProjection->end}', @Family = 0, @Category = 0
                ";
                $thisYearQueryResults = DB::connection('mssql')->selectResultSets($thisYearQquery);
                $saleResults = collect($thisYearQueryResults[2]);
                $purchaseResults = collect($thisYearQueryResults[3]);


                $categoriesData = $categories->map(function ($category) use ($familiesGoalSale,$categoriesGoalSale,$saleResults, $purchaseResults, $projectionResults) {
                    $current = $saleResults->where('CategoryId', $category->CategoryId)->sum('Current');
                    $old = $saleResults->where('CategoryId', $category->CategoryId)->sum('Old');
                    $total = $saleResults->where('CategoryId', $category->CategoryId)->sum('Amount');
                    $purchase = $purchaseResults->where('CategoryId', $category->CategoryId)->sum('Costo');
                    $purchaseVsSale = $total > 0 ? $purchase / $total * 100 : 0;
                    $projectionCurrent = $projectionResults->where('categoryid', $category->CategoryId)->sum('current');
                    $projectionOld = $projectionResults->where('categoryid', $category->CategoryId)->sum('old');
                    $projectionTotal = $projectionResults->where('categoryid', $category->CategoryId)->sum('total');
                    $projectionPurchase = $projectionResults->where('categoryid', $category->CategoryId)->sum('purchase');
                    $projectionPurchaseVsSale = $projectionTotal > 0 ? $projectionPurchase / $projectionTotal * 100 : 0;
                    $totalVsProjection = $projectionCurrent ? ($total/$projectionTotal*100) : 0;
                    $purchaseVsProjection = $projectionPurchase ? ($purchase/$projectionPurchase*100) : 0;

                    $categoryGoalSale = $categoriesGoalSale->firstWhere('categoryId', $category->CategoryId)->get('categoryPartialGoal') ?? 9;
                    $saleVsGoal = $categoryGoalSale > 0 ? $total/$categoryGoalSale*100 : 0;
                    return collect([
                        'id' => $category->CategoryId,
                        'categoryPartialGoal' => $categoryGoalSale,
                        'saleVsGoal' => number_format($saleVsGoal,0),
                        'name' => $category->Name,
                        'current' => number_format($current,0),
                        'old' => number_format($old,0),
                        'total' => number_format($total,0),
                        'purchase' => number_format($purchase,0),
                        'purchaseVsSale' => number_format($purchaseVsSale,0),
                        'totalVsProjection' => number_format($totalVsProjection,0),
                        'projection' => [
                            'current' => number_format($projectionCurrent,0),
                            'old' => number_format($projectionOld,0),
                            'total' => number_format($projectionTotal,0),
                            'purchase' => number_format($projectionPurchase,0),
                            'purchaseVsSale' => number_format($projectionPurchaseVsSale,0),
                            'purchaseVsProjection' => number_format($purchaseVsProjection,0)
                        ],
                        'families' => $category->families->map(function ($family) use($familiesGoalSale,$saleResults,$purchaseResults,$projectionResults) {
                            $current = $saleResults->where('FamilyId',$family->FamilyId)->sum('Current');
                            $old = $saleResults->where('FamilyId',$family->FamilyId)->sum('Old');
                            $total = $saleResults->where('FamilyId',$family->FamilyId)->sum('Amount');
                            $purchase = $purchaseResults->where('FamilyId',$family->FamilyId)->sum('Costo');
                            $purchaseVsSale = $total > 0 ? $purchase / $total * 100 : 0;
                            $projectionCurrent = $projectionResults->where('familyid', $family->FamilyId)->sum('current');
                            $projectionOld = $projectionResults->where('familyid', $family->FamilyId)->sum('old');
                            $projectionTotal = $projectionResults->where('familyid', $family->FamilyId)->sum('total');
                            $projectionPurchase = $projectionResults->where('familyid', $family->FamilyId)->sum('purchase');
                            $projectionPurchaseVsSale = $projectionTotal > 0 ? $projectionPurchase / $projectionTotal * 100 : 0;
                            $totalVsProjection = $projectionCurrent ? ($total/$projectionTotal*100) : 0;
                            $purchaseVsProjection = $projectionPurchase ? ($purchase/$projectionPurchase*100) : 0;

                            $familyGoalSale = $familiesGoalSale->firstWhere('familyId', $family->FamilyId)->get('partialGoalSaleFamily') ?? 9;
                            $saleVsGoal = $familyGoalSale > 0 ? $total/$familyGoalSale*100 : 0;
                            return collect([
                                'familyGoalSale' => $familyGoalSale, // 176,607
                                'saleVsGoal' => number_format($saleVsGoal,0), // 1.4735
                                'id' => $family->FamilyId,
                                'name' => $family->Name,
                                'current' => number_format($current,0),
                                'old' => number_format($old,0),
                                'total' => number_format($total,0),
                                'purchase' => number_format($purchase),
                                'purchaseVsSale' => number_format($purchaseVsSale,0),
                                'totalVsProjection' => number_format($totalVsProjection,0),
                                'projection' => [
                                    'current' => number_format($projectionCurrent,0),
                                    'old' => number_format($projectionOld,0),
                                    'total' => number_format($projectionTotal,0),
                                    'purchase' => number_format($projectionPurchase,0),
                                    'purchaseVsSale' => number_format($projectionPurchaseVsSale,0),
                                    'purchaseVsProjection' => number_format($purchaseVsProjection,0),
                                ]
                            ]);
                        })
                    ]);
                });


                //Calculamos para la tabla del TOTAL
                $totalsLastYearSale = $lastYearSaleResults->sum('Amount'); // Total de Venta año anterior 45,169,208
                $totalsProjection = $projectionResults->sum('total'); // Total de Projeccion 49,565,713
                $relationGoal = $totalsLastYearSale > 0 ? $totalsProjection / $totalsLastYearSale : 0; // Relacion Venta Anterior y Proyeccion 49,565,713/45,169,208 = 1.0973
                $lastYearPartialSale = $lastYearPartialSaleResults->sum('Amount'); // Total de Venta Parcial Año Anterior 1,772,687.3
                $partialGoalSale = $lastYearPartialSale * $relationGoal; // Meta de Venta Parcial 1,945,169.77
//                dd([
//                    'ventaAnoAnterior' => number_format($totalsLastYearSale,0),
//                    'proyeccion' => number_format($totalsProjection,0),
//                    'relacionMeta' => $relationGoal,
//                    'ventaParcialAnoAnterior' => number_format($lastYearPartialSale,0),
//                    'metaVentaParcial' => number_format($partialGoalSale,0),
//                ]);
                 // Relacion entre Meta de Venta Parcial y Venta actual - 2,438,972 / 1,945,169 = 1.2538
                $totalsCurrent = $saleResults->sum('Current');
                $totalsOld = $saleResults->sum('Old');
                $totalsTotal = $saleResults->sum('Amount');
                $totalsSaleVsGoal = $partialGoalSale > 0 ? $totalsTotal / $partialGoalSale * 100 : 0;
                $totalsPurchase = $purchaseResults->sum('Costo');
                $totalsPurchaseVsSale = $totalsTotal > 0 ? $totalsPurchase / $totalsTotal * 100 : 0;
                $totalsProjectionCurrent = $projectionResults->sum('current');
                $totalsProjectionOld = $projectionResults->sum('old');
                $totalsProjectionTotal = $projectionResults->sum('total');
                $totalVsProjection = $totalsTotal ? ($totalsTotal/$totalsProjectionTotal*100) : 0;
                $totalsProjectionPurchase = $projectionResults->sum('purchase');
                $totalsProjectionPurchaseVsSale = $totalsTotal > 0 ? $totalsProjectionPurchase / $totalsProjectionTotal * 100 : 0;
                $purchaseVsProjection = $totalsProjectionPurchase ? ($totalsPurchase/$totalsProjectionPurchase*100) : 0;
                $totals = collect([
                    'saleVsGoal' => number_format($totalsSaleVsGoal,0),
                    'current' => number_format($totalsCurrent,0),
                    'old' => number_format($totalsOld,0),
                    'total' => number_format($totalsTotal,0),
                    'purchase' => number_format($totalsPurchase,0),
                    'purchaseVsSale' => number_format($totalsPurchaseVsSale,0),
                    'totalVsProjection' => number_format($totalVsProjection,0),
                    'projection' => [
                        'current' => number_format($totalsProjectionCurrent,0),
                        'old' => number_format($totalsProjectionOld,0),
                        'total' => number_format($totalsProjectionTotal,0),
                        'purchase' => number_format($totalsProjectionPurchase,0),
                        'purchaseVsSale' => number_format($totalsProjectionPurchaseVsSale,0),
                        'purchaseVsProjection' => number_format($purchaseVsProjection,0)
                    ],
                ]);

                $data['categories'] = $categoriesData;
                $data['selectedProjection'] = $selectedProjection;
                $data['totals'] = $totals;
            }

        return view('projectionAmounts.index',$data);

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
        // dd($request->all());
        $family = Family::findOrFail($request->familyid);
        $projection = Projection::findOrFail($request->projectionid);
        // dd([$family,$projection]);
        $data = collect($request->input('data'));

        $transformedData = $data->map(function ($row) use ($projection, $family) {
            $row['new_sale'] = (float) filter_var($row['new_sale'], FILTER_SANITIZE_NUMBER_INT);
            $row['old_sale'] = (float) filter_var($row['old_sale'], FILTER_SANITIZE_NUMBER_INT);
            $row['purchase'] = (float) filter_var($row['purchase'], FILTER_SANITIZE_NUMBER_INT);

            $new_row['id'] = (int) $row['id'];
            $new_row['BranchId'] = (int) $row['branchid'];
            $new_row['projection_id'] = $projection->id;
            $new_row['FamilyId'] = $family->FamilyId;
            $new_row['new_sale'] = (float) $row['new_sale'];
            $new_row['old_sale'] = (float) $row['old_sale'];
            $new_row['purchase'] = (float) $row['purchase'];

            return $new_row;

        });


        $projectionAmounts = ProjectionAmount::where('projection_id',$projection->id)->where('FamilyId',$family->FamilyId)->get();

        foreach ($transformedData as $row) {
            $existing = $projectionAmounts->where('id',$row['id'] ?? null)->first();
            if($existing){
                if($existing->new_sale != $row['new_sale'] ||
                   $existing->old_sale != $row['old_sale'] ||
                   $existing->purchase != $row['purchase']){
                   $existing->update($row);
                }
            } else {
                ProjectionAmount::create([
                    'projection_id' => $row['projection_id'],
                    'BranchId' => $row['BranchId'],
                    'FamilyId' => $row['FamilyId'],
                    'new_sale' => $row['new_sale'],
                    'old_sale' => $row['old_sale'],
                    'purchase' => $row['purchase'],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Se han guardado los cambios');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $familyid = $id;
        $family = Family::find($id);
        $familyName = $family->Name;

        $initDate = '2024-09-01';
        $finalDate = '2024-12-31';
        $query = "
        EXEC dbo.DRGetSalesReportByFamily @From = '{$initDate}', @To = '{$finalDate}', @Family = {$familyid}, @Category = 0
        ";
        $queryResults = DB::connection('mssql')->selectResultSets($query);
        $branches = Branch::all();
        $saleResults = collect($queryResults[0]);
        $purchaseResults = collect($queryResults[1]);

        $projection = ProjectionAmount::with('families')->where('projection_id',1)->where('FamilyId',$familyid)->get();

        $filteredProjection = $projection->map(function ($row) use ($branches) {
            $branch = $branches->firstWhere('BranchId',$row->BranchId);
            $current = $row->new_sale;
            $old = $row->old_sale;
            $amount = $current + $old;
            return collect([
                'branchid' => $branch->BranchId,
                'name' => $branch->Name,
                'current' => $row->new_sale,
                'old' => $row->old_sale,
                'amount' => $amount,
                'purchase' => $row->purchase,
            ]);
        });

        $thisYearSalesTotal = $saleResults->reduce(function ($carry,$item) {
            return [
                'name' => 'Todas',
                'current' => $carry['current'] + $item->Current,
                'old' => $carry['old'] + $item->Old,
                'total' => $carry['total'] + $item->Amount
            ];
        },['current' => 0, 'old' => 0, 'total' => 0, 'purchase' => 0]);

        $purchaseTotal = $purchaseResults->reduce(function($carry,$item){
            return $carry + $item->Costo;
        },0);
        $projectionSalesTotal = $filteredProjection->reduce(function ($carry,$item, $purchaseTotal) {
            $new = $item['current'];
            $old = $item['old'];
            $amount = $item['amount'];
            $purchase = $item['purchase'];
            return [
                'name' => 'Todas',
                'current' => $carry['current'] + $new,
                'old' => $carry['old'] + $old,
                'total' => $carry['total'] + $amount,
                'purchase' => $carry['purchase'] + $purchase,
            ];
        },['name'=>'Todas','current' => 0, 'old' => 0, 'total' => 0, 'purchase' => 0]);

        $purchaseProjectionvsPurchaseTotal = 0;
        if($projectionSalesTotal['purchase'] == 0){
            $purchaseProjectionvsPurchaseTotal = 0;
        } else {
            $purchaseProjectionvsPurchaseTotal = number_format($purchaseTotal/$projectionSalesTotal['purchase']*100,1);
        }

        $thisYearSales = $saleResults->map(function ($row) use ($branches, $filteredProjection, $purchaseResults){
            $branch = $branches->firstWhere('BranchId',$row->branchid);
            $purchase = $purchaseResults->firstWhere('branchid', $row->branchid)->Costo ?? 0;
            $projectionSale = $filteredProjection->where('branchid',$row->branchid)->first() ?? ['current' => 0, 'old' => 0, 'amount' => 0, 'purchase' => 0];
            $projectionAmount = (float) ($projectionSale['amount'] ?? 0);
            $totalVsProjection = $projectionAmount != 0 ? (float) $row->Amount / (float)$projectionAmount * 100 : 0; // Aquí manejas la división
            $purchaseVsProjection = $projectionSale['purchase'] != 0 ? (float)$purchase/$projectionSale['purchase'] *100 : 0 ;
            $toPurchaseDlls = ($projectionSale['purchase'] - $purchase) / 19.5;
            return [
                'name' => $branch->Name,
                'id' => $branch->BranchId,
                'current' => (float) $row->Current,
                'old' => (float) $row->Old,
                'total' => (float) $row->Amount,
                'purchase' => (float) $purchase,
                'totalVsProjection' => (float) $totalVsProjection,
                'projection' => [
                    'current' => (float) $projectionSale['current'] ?? 0,
                    'old' => (float) $projectionSale['old'] ?? 0,
                    'amount' => (float) $projectionSale['amount'] ?? 0,
                    'purchase' => (float) $projectionSale['purchase'] ?? 0,
                    'purchaseVsProjection' => $purchaseVsProjection,
                    'toPurchaseDlls' => $toPurchaseDlls
                ]
            ];
        });

        // Formatear numeros para la vista
        // Formatear el totalizado para la vista
        $thisYearSalesTotalFormatted = [
            'name' => $thisYearSalesTotal['name'],
            'current' => number_format($thisYearSalesTotal['current'], 0, '.', ','), // Formato de moneda
            'old' => number_format($thisYearSalesTotal['old'], 0, '.', ','),
            'total' => number_format($thisYearSalesTotal['total'], 0, '.', ','),
            'purchase' => number_format($purchaseTotal, 0, '.', ','),

        ];

        if($projectionSalesTotal['total'] == 0){
            $totalVsProjection = 0;
        } else {
            $totalVsProjection = number_format(($thisYearSalesTotal['total']/$projectionSalesTotal['total']*100),1);
        }
        $projectionSalesTotalFormatted = [
            'name' => $projectionSalesTotal['name'],
            'current' => number_format($projectionSalesTotal['current'], 0, '.', ','), // Formato de moneda
            'old' => number_format($projectionSalesTotal['old'], 0, '.', ','),
            'total' => number_format($projectionSalesTotal['total'], 0, '.', ','),
            'purchase' => number_format($projectionSalesTotal['purchase'], 0, '.', ','),
            'totalVsProjection' => $totalVsProjection,
            'purchaseVsProjection' => $purchaseProjectionvsPurchaseTotal,
            'toPurchaseDlls' => number_format(($projectionSalesTotal['purchase'] - $purchaseTotal ) / 19.5,0),
        ];


        $thisYearSalesFormatted = $thisYearSales->map(function ($item){
            return [
                'name' => $item['name'],
                'id' => $item['id'],
                'current' => number_format($item['current'], 0, '.', ','), // Formato de moneda
                'old' => number_format($item['old'], 0, '.', ','),
                'total' => number_format($item['total'], 0, '.', ','),
                'purchase' => number_format($item['purchase'], 0, '.', ','),
                'totalVsProjection' => number_format($item['totalVsProjection'], 1, '.', ','),
                'projection' => [
                    'current' => number_format($item['projection']['current'],0) ?? 0,
                    'old' => number_format($item['projection']['old'],0) ?? 0,
                    'amount' => number_format($item['projection']['amount'],0) ?? 0,
                    'purchase' => number_format($item['projection']['purchase'],0) ?? 0,
                    'purchaseVsProjection' => number_format($item['projection']['purchaseVsProjection'],1),
                    'toPurchaseDlls' => number_format($item['projection']['toPurchaseDlls'],0)
                ]
            ];
        });

        $data = [
            'familyName' => $familyName,
            'thisYearSales' => $thisYearSalesFormatted,
            'thisYearSalesTotal' => $thisYearSalesTotalFormatted,
            'projectionSalesTotal' => $projectionSalesTotalFormatted,
        ];

        return view('projectionAmounts.show',$data);

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
