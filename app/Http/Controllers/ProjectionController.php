<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class ProjectionController extends Controller
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





        $initDate = '2024-09-01';
        $finalDate = '2024-12-31';
        $query = "
        EXEC dbo.DRGetSalesReportByFamily @From = '{$initDate}', @To = '{$finalDate}', @Family = 0, @Category = 12
        ";        
        $results = DB::connection('mssql')->selectResultSets($query);
        $results = collect($results[1]);        
        $families = Family::all();        
        
        $projectionSales = collect([
            ['branchid' => 6, 'familyid' => 7, 'current' => 300000, 'old' => 75523, 'amount' => 375523],
            ['branchid' => 22, 'familyid' => 7, 'current' => 94040, 'old' => 37792, 'amount' => 131832],
            ['branchid' => 3, 'familyid' => 7, 'current' => 230939, 'old' => 45837, 'amount' => 276776],
            ['branchid' => 12, 'familyid' => 7, 'current' => 132655, 'old' => 43389, 'amount' => 176043],
            ['branchid' => 13, 'familyid' => 7, 'current' => 97817, 'old' => 44397, 'amount' => 142214],
            ['branchid' => 23, 'familyid' => 7, 'current' => 75000, 'old' => 5000, 'amount' => 80000],
            ['branchid' => 24, 'familyid' => 7, 'current' => 524284, 'old' => 106267, 'amount' => 630551],
            ['branchid' => 2, 'familyid' => 7, 'current' => 242300, 'old' => 19182, 'amount' => 261481],
            ['branchid' => 11, 'familyid' => 7, 'current' => 90000, 'old' => 32851, 'amount' => 122851],
            ['branchid' => 15, 'familyid' => 7, 'current' => 50000, 'old' => 39543, 'amount' => 89543],
            ['branchid' => 7, 'familyid' => 7, 'current' => 180176, 'old' => 36904, 'amount' => 217080],
            ['branchid' => 8, 'familyid' => 7, 'current' => 189590, 'old' => 32959, 'amount' => 222549],
            ['branchid' => 9, 'familyid' => 7, 'current' => 452280, 'old' => 72253, 'amount' => 524533],
            ['branchid' => 1, 'familyid' => 7, 'current' => 35000, 'old' => 26868, 'amount' => 61868],
            // ['branchid' => 1, 'familyid' => 1, 'current' => 35000, 'old' => 26868, 'amount' => 61868],
            // ['branchid' => 1, 'familyid' => 6, 'current' => 35000, 'old' => 26868, 'amount' => 61868],
        ]);

        $groupedProjection = $projectionSales->groupBy('familyid');

        $projection = $groupedProjection->map(function($group) {
            return collect([
                'familyid' => $group->first()['familyid'],
                'current' => $group->sum('current'),
                'old' => $group->sum('old'),
                'amount' => $group->sum('amount'),
                ]);
            }, [ 'familyid' => 0, 'current' => 0, 'old' => 0,'amount' => 0]
        );
        
       
        $thisYearSalesTotal = $results->reduce(function ($carry,$item) {
            return [
                'name' => 'Todas',
                'current' => $carry['current'] + $item->Current,
                'old' => $carry['old'] + $item->Old,
                'total' => $carry['total'] + $item->Amount,
            ];
        },['current' => 0, 'old' => 0, 'total' => 0]); 

        
        $projectionSalesTotal = $projectionSales->reduce(function ($carry,$item) {
            return [
                'name' => 'Todas',
                'current' => $carry['current'] + $item['current'],
                'old' => $carry['old'] + $item['old'],
                'total' => $carry['total'] + $item['amount'],
            ];
        },['current' => 0, 'old' => 0, 'total' => 0]);
        
        
        
        $thisYearSales = $results->map(function ($row) use ($families, $projection){
            $family = $families->firstWhere('FamilyId',$row->familyid);                                    
            $projectionSale = $projection->where('familyid',$row->familyid)->first() ?? ['current' => 0, 'old' => 0, 'amount' => 0];
            // Evita la división entre 0
            $projectionAmount = (float) ($projectionSale['amount'] ?? 0);
            $totalVsProjection = $projectionAmount != 0 ? (float) $row->Amount / $projectionAmount : 0; // Aquí manejas la división            
            return [                
                'name' => $family->Name,
                'id' => $family->FamilyId,
                'current' => (float) $row->Current,
                'old' => (float) $row->Old,
                'total' => (float) $row->Amount,
                'totalVsProjection' => $totalVsProjection,
                'projection' => [
                    'current' => (float) $projectionSale['current'] ?? 0,
                    'old' => (float) $projectionSale['old'] ?? 0,
                    'amount' => (float) $projectionSale['amount'] ?? 0,
                ]
            ];
        });
                
        // Formatear numeros para la vista
        // Formatear el totalizado para la vista
        $thisYearSalesTotalFormatted = [
            'name' => $thisYearSalesTotal['name'],
            'current' => number_format($thisYearSalesTotal['current'], 0, '.', ','), // Formato de moneda
            'old' => number_format($thisYearSalesTotal['old'], 0, '.', ','),
            'total' => number_format($thisYearSalesTotal['total'], 0, '.', ',')
        ];
        $projectionSalesTotalFormatted = [
            'name' => $projectionSalesTotal['name'],
            'current' => number_format($projectionSalesTotal['current'], 0, '.', ','), // Formato de moneda
            'old' => number_format($projectionSalesTotal['old'], 0, '.', ','),
            'total' => number_format($projectionSalesTotal['total'], 0, '.', ','),
            'totalVsProjection' => number_format(($thisYearSalesTotal['total']/$projectionSalesTotal['total']*100),1)
        ];
        $thisYearSalesFormatted = $thisYearSales->map(function ($item){
            return [
                'name' => $item['name'],
                'id' => $item['id'],
                'current' => number_format($item['current'], 0, '.', ','), // Formato de moneda
                'old' => number_format($item['old'], 0, '.', ','),
                'total' => number_format($item['total'], 0, '.', ','),
                'totalVsProjection' => $item['totalVsProjection'],
                'projection' => [
                    'current' => number_format($item['projection']['current'],0) ?? 0,
                    'old' => number_format($item['projection']['old'],0) ?? 0,
                    'amount' => number_format($item['projection']['amount'],0) ?? 0,
                ]
            ];
        });


        $data = [            
            'thisYearSales' => $thisYearSalesFormatted,
            'thisYearSalesTotal' => $thisYearSalesTotalFormatted,
            'projectionSalesTotal' => $projectionSalesTotalFormatted,
        ];

        return view('projections.index',$data);        
        
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
        $initDate = '2024-09-01';
        $finalDate = '2024-12-31';
        $query = "
        EXEC dbo.DRGetSalesReportByFamily @From = '{$initDate}', @To = '{$finalDate}', @Family = {$id}, @Category = 0
        ";
        //$results = collect(DB::connection('mssql')->select($query));
        $results = DB::connection('mssql')->selectResultSets($query);
        $results = collect($results[0]);
        $branches = Branch::all();
        $family = Family::find($id)->Name;
        
        $projectionSales = collect([
            ['branchid' => 6, 'familyid' => 7, 'current' => 300000, 'old' => 75523, 'amount' => 375523],
            ['branchid' => 22, 'familyid' => 7, 'current' => 94040, 'old' => 37792, 'amount' => 131832],
            ['branchid' => 3, 'familyid' => 7, 'current' => 230939, 'old' => 45837, 'amount' => 276776],
            ['branchid' => 12, 'familyid' => 7, 'current' => 132655, 'old' => 43389, 'amount' => 176043],
            ['branchid' => 13, 'familyid' => 7, 'current' => 97817, 'old' => 44397, 'amount' => 142214],
            ['branchid' => 23, 'familyid' => 7, 'current' => 75000, 'old' => 5000, 'amount' => 80000],
            ['branchid' => 24, 'familyid' => 7, 'current' => 524284, 'old' => 106267, 'amount' => 630551],
            ['branchid' => 2, 'familyid' => 7, 'current' => 242300, 'old' => 19182, 'amount' => 261481],
            ['branchid' => 11, 'familyid' => 7, 'current' => 90000, 'old' => 32851, 'amount' => 122851],
            ['branchid' => 15, 'familyid' => 7, 'current' => 50000, 'old' => 39543, 'amount' => 89543],
            ['branchid' => 7, 'familyid' => 7, 'current' => 180176, 'old' => 36904, 'amount' => 217080],
            ['branchid' => 8, 'familyid' => 7, 'current' => 189590, 'old' => 32959, 'amount' => 222549],
            ['branchid' => 9, 'familyid' => 7, 'current' => 452280, 'old' => 72253, 'amount' => 524533],
            ['branchid' => 1, 'familyid' => 7, 'current' => 35000, 'old' => 26868, 'amount' => 61868],
        ]);
       
        $thisYearSalesTotal = $results->reduce(function ($carry,$item) {
            return [
                'name' => 'Todas',
                'current' => $carry['current'] + $item->Current,
                'old' => $carry['old'] + $item->Old,
                'total' => $carry['total'] + $item->Amount,
            ];
        },['current' => 0, 'old' => 0, 'total' => 0]); 

        $projectionSalesTotal = $projectionSales->reduce(function ($carry,$item) {
            return [
                'name' => 'Todas',
                'current' => $carry['current'] + $item['current'],
                'old' => $carry['old'] + $item['old'],
                'total' => $carry['total'] + $item['amount'],
            ];
        },['current' => 0, 'old' => 0, 'total' => 0]); 

        $thisYearSales = $results->map(function ($row) use ($branches, $projectionSales,$id){
            $branch = $branches->firstWhere('BranchId',$row->branchid);
            
            $projectionSale = $projectionSales->where('branchid',$row->branchid)->where('familyid',$id)->first() ?? ['current' => 0, 'old' => 0, 'amount' => 0];
            // Evita la división entre 0
            $projectionAmount = (float) ($projectionSale['amount'] ?? 0);
            $totalVsProjection = $projectionAmount != 0 ? (float) $row->Amount / $projectionAmount : 0; // Aquí manejas la división            
            
            return [                
                'name' => $branch->Name,
                'current' => (float) $row->Current,
                'old' => (float) $row->Old,
                'total' => (float) $row->Amount,
                'totalVsProjection' => $totalVsProjection,
                'projection' => [
                    'current' => (float) $projectionSale['current'],
                    'old' => (float) $projectionSale['old'],
                    'amount' => (float) $projectionSale['amount'],
                ]
            ];
        });
        

        
        // Formatear numeros para la vista
        // Formatear el totalizado para la vista
        $thisYearSalesTotalFormatted = [
            'name' => $thisYearSalesTotal['name'],
            'current' => number_format($thisYearSalesTotal['current'], 0, '.', ','), // Formato de moneda
            'old' => number_format($thisYearSalesTotal['old'], 0, '.', ','),
            'total' => number_format($thisYearSalesTotal['total'], 0, '.', ',')
        ];
        $projectionSalesTotalFormatted = [
            'name' => $projectionSalesTotal['name'],
            'current' => number_format($projectionSalesTotal['current'], 0, '.', ','), // Formato de moneda
            'old' => number_format($projectionSalesTotal['old'], 0, '.', ','),
            'total' => number_format($projectionSalesTotal['total'], 0, '.', ','),
            'totalVsProjection' => number_format(($thisYearSalesTotal['total']/$projectionSalesTotal['total']*100),1)
        ];
        $thisYearSalesFormatted = $thisYearSales->map(function ($item){
            return [
                'name' => $item['name'],
                'current' => number_format($item['current'], 0, '.', ','), // Formato de moneda
                'old' => number_format($item['old'], 0, '.', ','),
                'total' => number_format($item['total'], 0, '.', ','),
                'totalVsProjection' => $item['totalVsProjection'],
                'projection' => [
                    'current' => number_format($item['projection']['current'],0) ?? 0,
                    'old' => number_format($item['projection']['old'],0) ?? 0,
                    'amount' => number_format($item['projection']['amount'],0) ?? 0,
                ]
            ];
        });


        $data = [
            'family' => $family,
            'thisYearSales' => $thisYearSalesFormatted,
            'thisYearSalesTotal' => $thisYearSalesTotalFormatted,
            'projectionSalesTotal' => $projectionSalesTotalFormatted,
        ];

        return view('projections.show',$data);

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
