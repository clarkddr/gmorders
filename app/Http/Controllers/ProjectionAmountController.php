<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Family;
use App\Models\ProjectionAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectionAmountController extends Controller
{

    public function index()
    {       

        $data  = collect([
            ['name'=> 'TA', 'value' => 50],
            ['name'=> 'G1', 'value' => 150],
            ['name'=> 'G2', 'value' => 151],
            ['name'=> 'CA', 'value' => 350],
            ['name'=> 'S1', 'value' => 148],
            ['name'=> 'S2', 'value' => 224],
            ['name'=> 'S3', 'value' => 360],
            ['name'=> 'V2', 'value' => 120],
            ['name'=> 'V3', 'value' => 109],
            ['name'=> 'V4', 'value' => 115],
            ['name'=> 'V6', 'value' => 98],
            ['name'=> 'V7', 'value' => 119],

        ]);
        

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

        $category = request('category');        
        $categoryId = $category ? Category::find($category)->CategoryId : 12;  
        $categoryName = $category ? Category::find($category)->Name : 'Calzado';  
        $initDate = '2024-09-01';
        $finalDate = '2024-12-31';
        $query = "
        EXEC dbo.DRGetSalesReportByFamily @From = '{$initDate}', @To = '{$finalDate}', @Family = 0, @Category = {$categoryId}
        ";        
        $queryResults = DB::connection('mssql')->selectResultSets($query);        
        $saleResults = collect($queryResults[2]);
        $purchaseResults = collect($queryResults[3]);

        $families = Family::whereHas('subcategories', function ($query) use ($categoryId){
            $query->whereHas('category', function ($query) use ($categoryId) {
                $query->where('CategoryHasSubcategory.CategoryId', $categoryId);
            });
        })->distinct()->get();

        $projection = ProjectionAmount::with('families')->where('projection_id',1)->get();                
        $groupedProjection = $projection->groupBy('FamilyId');        
        $allFamilies = Family::all();

        $projection = $groupedProjection->filter(function ($group) use ($families) {
            return $families->contains('FamilyId',$group->first()->FamilyId);
        });
        
        $filteredProjection = $projection->map(function($group) use ($allFamilies) {
            $family = $allFamilies->firstWhere('FamilyId',$group->first()->FamilyId);
            $current = $group->sum('new_sale');
            $old = $group->sum('old_sale');
            $amount = $current + $old;
            $purchase = $group->sum('purchase');
            return collect([
                'familyid' => $family->FamilyId,
                'name' => $family->Name,
                'current' => $current,
                'old' => $old,
                'amount' => $amount,
                'purchase' => $purchase
                ]);
            }
        );             

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

        $projectionSalesTotal = $filteredProjection->reduce(function ($carry,$group) {            
            $new = $group['current'];            
            $old = $group['old'];            
            $amount = $group['amount'];
            $purchase = $group['purchase'];
            return [
                'name' => 'Todas',
                'current' => $carry['current'] + $new,
                'old' => $carry['old'] + $old,
                'total' => $carry['total'] + $amount,
                'purchase' => $carry['purchase'] + $purchase
            ];
        },['name'=>'Todas','current' => 0, 'old' => 0, 'total' => 0, 'purchase' => 0]);
        
        $purchaseProjectionvsPurchaseTotal = 0;
        if($projectionSalesTotal['purchase'] == 0){
            $purchaseProjectionvsPurchaseTotal = 0;
        } else {
            $purchaseProjectionvsPurchaseTotal = number_format($purchaseTotal/$projectionSalesTotal['purchase']*100,1);
        }

        $thisYearSales = $saleResults->map(function ($row) use ($allFamilies, $filteredProjection, $purchaseResults){            
            $family = $allFamilies->firstWhere('FamilyId',$row->familyid);            
            $purchase = $purchaseResults->firstWhere('familyid', $row->familyid)->Costo ?? 0;
            $projectionSale = $filteredProjection->where('familyid',$row->familyid)->first() ?? ['current' => 0, 'old' => 0, 'amount' => 0, 'purchase' => 0];
            $projectionAmount = (float) ($projectionSale['amount'] ?? 0);
            $totalVsProjection = $projectionAmount != 0 ? (float) $row->Amount / $projectionAmount *100 : 0; // Aquí manejas la división
            $purchaseVsProjection = $projectionSale['purchase'] != 0 ? (float)$purchase/$projectionSale['purchase'] : 0 ;
            return [
                'name' => $family->Name,
                'id' => $family->FamilyId,
                'current' => (float) $row->Current,
                'old' => (float) $row->Old,
                'total' => (float) $row->Amount,
                'purchase' => (float) $purchase,
                'totalVsProjection' => (float)$totalVsProjection,
                'projection' => [
                    'current' => (float) $projectionSale['current'] ?? 0,
                    'old' => (float) $projectionSale['old'] ?? 0,
                    'amount' => (float) $projectionSale['amount'] ?? 0,
                    'purchase' => (float) $projectionSale['purchase'] ?? 0,
                    'purchaseVsProjection' => $purchaseVsProjection
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
            'purchase' => number_format($purchaseTotal, 0, '.', ',')
          
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
            'purchaseVsProjection' => $purchaseProjectionvsPurchaseTotal
        ];


        $thisYearSalesFormatted = $thisYearSales->map(function ($item){
            return [    
                'name' => $item['name'],
                'id' => $item['id'],
                'current' => number_format($item['current'], 0, '.', ','), // Formato de moneda
                'old' => number_format($item['old'], 0, '.', ','),
                'total' => number_format($item['total'], 0, '.', ','),
                'purchase' => number_format($item['purchase'], 0, '.', ','),
                'totalVsProjection' => number_format($item['totalVsProjection'],1,'.',','),
                'projection' => [
                    'current' => number_format($item['projection']['current'],0) ?? 0,
                    'old' => number_format($item['projection']['old'],0) ?? 0,
                    'amount' => number_format($item['projection']['amount'],0) ?? 0,
                    'purchase' => number_format($item['projection']['purchase'],0) ?? 0,
                    'purchaseVsProjection' => number_format($item['projection']['purchaseVsProjection'],1)
                ]
            ];
        });

        $data = [   
            'categoryName' => $categoryName,
            'thisYearSales' => $thisYearSalesFormatted,
            'thisYearSalesTotal' => $thisYearSalesTotalFormatted,
            'projectionSalesTotal' => $projectionSalesTotalFormatted,
        ];

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
        //
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
        $projectionSalesTotal = $filteredProjection->reduce(function ($carry,$item) {                     
            $new = $item['current'];            
            $old = $item['old'];            
            $amount = $item['amount'];
            $purchase = $item['purchase'];
            return [
                'name' => 'Todas',
                'current' => $carry['current'] + $new,
                'old' => $carry['old'] + $old,
                'total' => $carry['total'] + $amount,
                'purchase' => $carry['purchase'] + $purchase
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
                    'purchaseVsProjection' => $purchaseVsProjection
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
            'purchase' => number_format($purchaseTotal, 0, '.', ',')
          
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
            'purchaseVsProjection' => $purchaseProjectionvsPurchaseTotal
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
                    'purchaseVsProjection' => number_format($item['projection']['purchaseVsProjection'],1)
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
