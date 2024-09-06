<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $image->delete();
        return redirect()->back();
    }

    public function plan(Request $request){
        $rows = collect([
            ["family" => "Basico", "sucursal" => "Mia", "venta" => 41358.70, "compra" => 12716.916000],
            ["family" => "Basico", "sucursal" => "Morelos", "venta" => 29350.80, "compra" => 11262.075000],
            ["family" => "Basico", "sucursal" => "Glamour", "venta" => 22391.30, "compra" => 9854.331000],
            ["family" => "Basico", "sucursal" => "San Luis 3", "venta" => 47731.10, "compra" => 16306.479000],
            ["family" => "Basico", "sucursal" => "Galerias", "venta" => 34920.70, "compra" => 13030.359000],
            ["family" => "Basico", "sucursal" => "San Luis 1", "venta" => 20771.20, "compra" => 9957.147000],
            ["family" => "Basico", "sucursal" => "Maluk", "venta" => 52542.90, "compra" => 15977.988000],
            ["family" => "Basico", "sucursal" => "Fase", "venta" => 23355.90, "compra" => 9863.394000],
            ["family" => "Basico", "sucursal" => "Carranza", "venta" => 62200.30, "compra" => 19347.543000],
            ["family" => "Basico", "sucursal" => "Telaviv", "venta" => 25007.30, "compra" => 8287.116000],
            ["family" => "Basico", "sucursal" => "Hermosillo", "venta" => 32876.60, "compra" => 11842.548000],
            ["family" => "Basico", "sucursal" => "Oaxaca", "venta" => 26556.70, "compra" => 9854.331000],
            ["family" => "Basico", "sucursal" => "San Luis 2", "venta" => 35878.50, "compra" => 12728.034000],
            ["family" => "Basico", "sucursal" => "Loa", "venta" => 35829.50, "compra" => 8586.144000],
            ["family" => "Blusa", "sucursal" => "Galerias", "venta" => 260769.30, "compra" => 90592.144500],
            ["family" => "Blusa", "sucursal" => "San Luis 3", "venta" => 692848.00, "compra" => 262832.863500],
            ["family" => "Blusa", "sucursal" => "Maluk", "venta" => 847246.20, "compra" => 324713.427500],
            ["family" => "Blusa", "sucursal" => "San Luis 2", "venta" => 241901.70, "compra" => 89828.452500],
            ["family" => "Blusa", "sucursal" => "Glamour", "venta" => 112262.70, "compra" => 48500.116000],
            ["family" => "Blusa", "sucursal" => "Telaviv", "venta" => 79505.50, "compra" => 39893.315000],
            ["family" => "Blusa", "sucursal" => "San Luis 1", "venta" => 180013.50, "compra" => 60565.624500],
            ["family" => "Blusa", "sucursal" => "Fase", "venta" => 132034.70, "compra" => 45328.121000],
            ["family" => "Blusa", "sucursal" => "Hermosillo", "venta" => 171746.06, "compra" => 64797.137000],
            ["family" => "Blusa", "sucursal" => "Loa", "venta" => 130400.50, "compra" => 50025.978000],
            ["family" => "Blusa", "sucursal" => "Morelos", "venta" => 138259.80, "compra" => 55192.814000],
            ["family" => "Blusa", "sucursal" => "Mia", "venta" => 229245.80, "compra" => 87658.294500],
            ["family" => "Blusa", "sucursal" => "Oaxaca", "venta" => 119477.90, "compra" => 47826.881000],
            ["family" => "Blusa", "sucursal" => "Carranza", "venta" => 636498.45, "compra" => 255223.384500],
            ["family" => "Bodysuit", "sucursal" => "Maluk", "venta" => 28970.70, "compra" => 8629.111500],
            ["family" => "Bodysuit", "sucursal" => "Morelos", "venta" => 1303.50, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Oaxaca", "venta" => 510.00, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Glamour", "venta" => 414.60, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Mia", "venta" => 2285.00, "compra" => 1300.137000],
            ["family" => "Bodysuit", "sucursal" => "Fase", "venta" => 1180.20, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Loa", "venta" => 930.50, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Carranza", "venta" => 30592.60, "compra" => 6800.161500],
            ["family" => "Bodysuit", "sucursal" => "San Luis 3", "venta" => 26313.30, "compra" => 7955.911500],
            ["family" => "Bodysuit", "sucursal" => "Hermosillo", "venta" => 1406.50, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "San Luis 1", "venta" => 5268.20, "compra" => 346.437000],
            ["family" => "Bodysuit", "sucursal" => "Galerias", "venta" => 3121.70, "compra" => 1300.137000],
            ["family" => "Bodysuit", "sucursal" => "San Luis 2", "venta" => 3910.20, "compra" => 1300.137000],
            ["family" => "Bodysuit", "sucursal" => "Telaviv", "venta" => 1047.00, "compra" => 0.000000],
            ["family" => "Chamarra", "sucursal" => "San Luis 1", "venta" => 27155.70, "compra" => 2371.500000],
            ["family" => "Chamarra", "sucursal" => "Maluk", "venta" => 129423.80, "compra" => 19968.840000],
            ["family" => "Chamarra", "sucursal" => "Telaviv", "venta" => 8585.50, "compra" => 0.000000],
            ["family" => "Chamarra", "sucursal" => "Mia", "venta" => 33745.80, "compra" => 2371.500000],
            ["family" => "Chamarra", "sucursal" => "Oaxaca", "venta" => 8911.00, "compra" => 0.000000],
            ["family" => "Chamarra", "sucursal" => "Carranza", "venta" => 144500.70, "compra" => 12938.040000],
            ["family" => "Chamarra", "sucursal" => "Galerias", "venta" => 40423.80, "compra" => 3215.220000],
            ["family" => "Chamarra", "sucursal" => "Glamour", "venta" => 9887.10, "compra" => 0.000000],
            ["family" => "Chamarra", "sucursal" => "San Luis 2", "venta" => 41108.10, "compra" => 2371.500000],
            ["family" => "Chamarra", "sucursal" => "Hermosillo", "venta" => 18900.00, "compra" => 0.000000],
            ["family" => "Chamarra", "sucursal" => "Morelos", "venta" => 22081.40, "compra" => 0.000000],
            ["family" => "Chamarra", "sucursal" => "Loa", "venta" => 23231.00, "compra" => 2371.500000],
            ["family" => "Chamarra", "sucursal" => "Fase", "venta" => 10906.20, "compra" => 0.000000],
            ["family" => "Chamarra", "sucursal" => "San Luis 3", "venta" => 137193.10, "compra" => 12938.040000],
            ["family" => "Falda", "sucursal" => "San Luis 2", "venta" => 39557.90, "compra" => 16997.265000],
            ["family" => "Falda", "sucursal" => "Hermosillo", "venta" => 11158.70, "compra" => 2454.075000],
            ["family" => "Falda", "sucursal" => "Fase", "venta" => 3998.50, "compra" => 1216.800000],
            ["family" => "Falda", "sucursal" => "Glamour", "venta" => 4272.50, "compra" => 1216.800000],
            ["family" => "Falda", "sucursal" => "Maluk", "venta" => 133915.70, "compra" => 60322.726800],
            ["family" => "Falda", "sucursal" => "Telaviv", "venta" => 4460.60, "compra" => 1216.800000],
            ["family" => "Falda", "sucursal" => "Mia", "venta" => 40295.30, "compra" => 16259.355000],
            ["family" => "Falda", "sucursal" => "Galerias", "venta" => 50394.70, "compra" => 18677.715000],
            ["family" => "Falda", "sucursal" => "Morelos", "venta" => 6550.00, "compra" => 2454.075000],
            ["family" => "Falda", "sucursal" => "Loa", "venta" => 7875.80, "compra" => 1977.300000],
            ["family" => "Falda", "sucursal" => "Carranza", "venta" => 102467.40, "compra" => 47436.286800],
            ["family" => "Falda", "sucursal" => "San Luis 1", "venta" => 19153.10, "compra" => 9766.800000],
            ["family" => "Falda", "sucursal" => "Oaxaca", "venta" => 5116.00, "compra" => 2454.075000],
            ["family" => "Falda", "sucursal" => "San Luis 3", "venta" => 102519.00, "compra" => 44767.696800],
            ["family" => "Kimono", "sucursal" => "Carranza", "venta" => 12382.00, "compra" => 6477.480000],
            ["family" => "Kimono", "sucursal" => "San Luis 1", "venta" => 217.50, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Telaviv", "venta" => 335.00, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "San Luis 3", "venta" => 9874.50, "compra" => 6477.480000],
            ["family" => "Kimono", "sucursal" => "Maluk", "venta" => 14539.50, "compra" => 6477.480000],
            ["family" => "Kimono", "sucursal" => "Mia", "venta" => 1325.00, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Glamour", "venta" => 560.00, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Oaxaca", "venta" => 102.50, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Galerias", "venta" => 544.00, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Telaviv", "venta" => 684.70, "compra" => 1507.500000],
            ["family" => "Monoshort", "sucursal" => "Fase", "venta" => 512.50, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Mia", "venta" => 487.50, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "San Luis 2", "venta" => 4319.50, "compra" => 1562.085000],
            ["family" => "Monoshort", "sucursal" => "San Luis 3", "venta" => 40584.10, "compra" => 16170.546600],
            ["family" => "Monoshort", "sucursal" => "Glamour", "venta" => 1204.50, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Carranza", "venta" => 30539.20, "compra" => 16472.046600],
            ["family" => "Monoshort", "sucursal" => "Galerias", "venta" => 1006.20, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Maluk", "venta" => 44492.70, "compra" => 18042.846600],
            ["family" => "Monoshort", "sucursal" => "San Luis 1", "venta" => 343.00, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Loa", "venta" => 2427.50, "compra" => 1989.000000],
            ["family" => "Monoshort", "sucursal" => "Hermosillo", "venta" => 905.50, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Oaxaca", "venta" => 177.50, "compra" => 0.000000],
            ["family" => "Pantalon", "sucursal" => "Oaxaca", "venta" => 101299.10, "compra" => 31053.934500],
            ["family" => "Pantalon", "sucursal" => "Fase", "venta" => 100438.00, "compra" => 34897.489500],
            ["family" => "Pantalon", "sucursal" => "Maluk", "venta" => 661532.40, "compra" => 246234.065800],
            ["family" => "Pantalon", "sucursal" => "San Luis 1", "venta" => 124654.70, "compra" => 46417.434000],
            ["family" => "Pantalon", "sucursal" => "San Luis 3", "venta" => 437764.30, "compra" => 166140.718800],
            ["family" => "Pantalon", "sucursal" => "Loa", "venta" => 106122.60, "compra" => 34206.139500],
            ["family" => "Pantalon", "sucursal" => "Galerias", "venta" => 186738.80, "compra" => 67526.409000],
            ["family" => "Pantalon", "sucursal" => "Morelos", "venta" => 104655.60, "compra" => 31405.684500],
            ["family" => "Pantalon", "sucursal" => "San Luis 2", "venta" => 182488.00, "compra" => 64548.079800],
            ["family" => "Pantalon", "sucursal" => "Telaviv", "venta" => 76384.10, "compra" => 34215.847500],
            ["family" => "Pantalon", "sucursal" => "Mia", "venta" => 177694.30, "compra" => 59735.184000],
            ["family" => "Pantalon", "sucursal" => "Glamour", "venta" => 88311.40, "compra" => 32782.684500],
            ["family" => "Pantalon", "sucursal" => "Hermosillo", "venta" => 112210.10, "compra" => 40386.709500],
            ["family" => "Pantalon", "sucursal" => "Carranza", "venta" => 454543.70, "compra" => 157549.425800],
            ["family" => "Saco/Sueter", "sucursal" => "Morelos", "venta" => 8796.70, "compra" => 0.000000],
            ["family" => "Saco/Sueter", "sucursal" => "Maluk", "venta" => 53575.50, "compra" => 10379.610000],
            ["family" => "Saco/Sueter", "sucursal" => "Mia", "venta" => 10465.60, "compra" => 1963.500000],
            ["family" => "Saco/Sueter", "sucursal" => "San Luis 1", "venta" => 11832.80, "compra" => 0.000000],
            ["family" => "Saco/Sueter", "sucursal" => "Glamour", "venta" => 4235.90, "compra" => 0.000000],
            ["family" => "Saco/Sueter", "sucursal" => "Loa", "venta" => 7183.20, "compra" => 0.000000],
            ["family" => "Saco/Sueter", "sucursal" => "Hermosillo", "venta" => 9897.50, "compra" => 0.000000],
            ["family" => "Saco/Sueter", "sucursal" => "Galerias", "venta" => 13108.10, "compra" => 1963.500000],
            ["family" => "Saco/Sueter", "sucursal" => "San Luis 3", "venta" => 61308.70, "compra" => 10379.610000],
            ["family" => "Saco/Sueter", "sucursal" => "Oaxaca", "venta" => 10926.40, "compra" => 0.000000],
            ["family" => "Saco/Sueter", "sucursal" => "Fase", "venta" => 8361.70, "compra" => 0.000000],
            ["family" => "Saco/Sueter", "sucursal" => "Telaviv", "venta" => 7700.00, "compra" => 0.000000],
            ["family" => "Saco/Sueter", "sucursal" => "San Luis 2", "venta" => 13891.80, "compra" => 1963.500000],
            ["family" => "Saco/Sueter", "sucursal" => "Carranza", "venta" => 69839.10, "compra" => 10379.610000],
            ["family" => "Short", "sucursal" => "Carranza", "venta" => 68198.00, "compra" => 21881.413800],
            ["family" => "Short", "sucursal" => "Oaxaca", "venta" => 14642.20, "compra" => 7719.413400],
            ["family" => "Short", "sucursal" => "San Luis 3", "venta" => 62392.40, "compra" => 18628.453800],
            ["family" => "Short", "sucursal" => "Maluk", "venta" => 96527.70, "compra" => 34953.313800],
            ["family" => "Short", "sucursal" => "Hermosillo", "venta" => 24863.20, "compra" => 10897.688400],
            ["family" => "Short", "sucursal" => "Glamour", "venta" => 24929.40, "compra" => 6990.385200],
            ["family" => "Short", "sucursal" => "Mia", "venta" => 26336.10, "compra" => 11165.753400],
            ["family" => "Short", "sucursal" => "Telaviv", "venta" => 12181.40, "compra" => 6555.308400],
            ["family" => "Short", "sucursal" => "Loa", "venta" => 17836.60, "compra" => 6850.463400],
            ["family" => "Short", "sucursal" => "Morelos", "venta" => 20350.00, "compra" => 8991.428400],
            ["family" => "Short", "sucursal" => "Fase", "venta" => 19639.80, "compra" => 7984.013400],
            ["family" => "Short", "sucursal" => "Galerias", "venta" => 32210.30, "compra" => 11650.718400],
            ["family" => "Short", "sucursal" => "San Luis 2", "venta" => 38410.80, "compra" => 12526.457400],
            ["family" => "Short", "sucursal" => "San Luis 1", "venta" => 21410.00, "compra" => 6557.845200],
            ["family" => "Vestido", "sucursal" => "Oaxaca", "venta" => 24494.20, "compra" => 14127.520000],
            ["family" => "Vestido", "sucursal" => "Fase", "venta" => 31109.70, "compra" => 18201.220000],
            ["family" => "Vestido", "sucursal" => "San Luis 3", "venta" => 282109.10, "compra" => 99425.391000],
            ["family" => "Vestido", "sucursal" => "Glamour", "venta" => 32449.50, "compra" => 16963.480000],
            ["family" => "Vestido", "sucursal" => "Maluk", "venta" => 385536.90, "compra" => 136315.472800],
            ["family" => "Vestido", "sucursal" => "Mia", "venta" => 55733.30, "compra" => 23223.246000],
            ["family" => "Vestido", "sucursal" => "Telaviv", "venta" => 15963.30, "compra" => 12603.070000],
            ["family" => "Vestido", "sucursal" => "Loa", "venta" => 43129.10, "compra" => 19746.450000],
            ["family" => "Vestido", "sucursal" => "Morelos", "venta" => 36442.15, "compra" => 17324.425000],
            ["family" => "Vestido", "sucursal" => "Galerias", "venta" => 61676.40, "compra" => 26414.046000],
            ["family" => "Vestido", "sucursal" => "San Luis 2", "venta" => 43076.50, "compra" => 16159.260000],
            ["family" => "Vestido", "sucursal" => "San Luis 1", "venta" => 26534.30, "compra" => 8588.850000],
            ["family" => "Vestido", "sucursal" => "Carranza", "venta" => 235280.90, "compra" => 98339.461000],
            ["family" => "Vestido", "sucursal" => "Hermosillo", "venta" => 40970.20, "compra" => 16611.175000],
        ]);

        $families = $rows->pluck('family')->unique();
        $minimum = 30;
        $maximum = 42;
        $tc = 18.50;
        
        $family = $request->family;        
        if ($request->family == NULL) {
            $family = 'all';    
        }
        
        $filteredRows = $rows->filter(function ($row) use ($family){
            return $row['family'] === $family;
        });        
        
        $totalSugested = $filteredRows->reduce(function ($carry, $item) use ($maximum, $tc) {
            $venta = $item['venta'];
            $compra = $item['compra'];
            $sugested = ($venta * ($maximum / 100) - $compra) / $tc;
            $sugested = $sugested > 0 ? $sugested : 0.00;
            return $carry + $sugested;
        }, 0); // El valor inicial de $carry es 0

        $totalSale = $filteredRows->reduce(function ($carry,$item) {
            return $carry + $item['venta'];
        },0);
        $totalPurchase = $filteredRows->reduce(function ($carry,$item) {
            return $carry + $item['compra'];
        },0);
        $totalRelation = $totalPurchase != 0 ? number_format(($totalPurchase/$totalSale) * 100, 0, '.',',') : '0';


        $formattedRows = $filteredRows->map(function ($item) use($maximum,$tc) {
            $venta = $item['venta'];
            $compra = $item['compra'];            
            $relation = $compra != 0 ? number_format(($compra/$venta) * 100, 0, '.',',') : '0';
            $sugested = ($venta * ($maximum/100) - $compra)/$tc;
            $sugested = $sugested > 0 ? $sugested : 0.00;            

            return [
                'family' => $item['family'],
                'sucursal' => $item['sucursal'],
                'venta' => number_format($item['venta'], 0), // Formato: 12,345.67
                'compra' => number_format($item['compra'],0), // Formato: 12,345.67
                'relation' => $relation,
                'sugested' =>  number_format($sugested,0,'.',',')
            ];
        })->sortBy('sucursal');
        
        $branches = [
            [ 'id' => 1, 'name' => 'Telaviv', 'abbreviation' => 'TA'],
            [ 'id' => 2, 'name' => 'Besuto', 'abbreviation' => 'G2'],
            [ 'id' => 3, 'name' => 'Galerias', 'abbreviation' => 'G1'],
            [ 'id' => 5, 'name' => 'Carranza', 'abbreviation' => 'CA'],
            [ 'id' => 23, 'name' => 'Loa', 'abbreviation' => 'LO'],
            [ 'id' => 24, 'name' => 'Sendero', 'abbreviation' => 'SE'],
            [ 'id' => 7, 'name' => 'San Luis 1', 'abbreviation' => 'S1'],
            [ 'id' => 8, 'name' => 'San Luis 2', 'abbreviation' => 'S2'],
            [ 'id' => 9, 'name' => 'San Luis 3', 'abbreviation' => 'S3'],
            [ 'id' => 11, 'name' => 'Morelos', 'abbreviation' => 'V2'],
            [ 'id' => 12, 'name' => 'Glamour', 'abbreviation' => 'V3'],
            [ 'id' => 13, 'name' => 'Hermosillo', 'abbreviation' => 'V4'],
            [ 'id' => 15, 'name' => 'Oaxaca', 'abbreviation' => 'V6'],
            [ 'id' => 22, 'name' => 'Fase', 'abbreviation' => 'V7'],
        ];
      

        $data = [
            'rows' => $formattedRows,
            'branches' => $branches,
            'family' => $family,
            'families' => $families,
            'minimum' => $minimum,
            'maximum' => $maximum,
            'tc' => $tc,
            'totalSugested' => number_format($totalSugested,0),
            'totalSale' => number_format($totalSale,0),
            'totalPurchase' => number_format($totalPurchase,0),
            'totalRelation' => $totalRelation

        ];
        return view('plan',$data);
    }
}
