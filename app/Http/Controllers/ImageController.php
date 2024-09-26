<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            ["family" => "Basico", "sucursal" => "Mia", "venta" => 42599.70, "compra" => 12716.916000],
            ["family" => "Basico", "sucursal" => "Morelos", "venta" => 31099.20, "compra" => 11262.075000],
            ["family" => "Basico", "sucursal" => "San Luis 3", "venta" => 50380.10, "compra" => 16306.479000],
            ["family" => "Basico", "sucursal" => "Galerias", "venta" => 36952.40, "compra" => 13030.359000],
            ["family" => "Basico", "sucursal" => "Glamour", "venta" => 23523.80, "compra" => 9854.331000],
            ["family" => "Basico", "sucursal" => "San Luis 1", "venta" => 23708.30, "compra" => 9957.147000],
            ["family" => "Basico", "sucursal" => "Maluk", "venta" => 54600.30, "compra" => 15977.988000],
            ["family" => "Basico", "sucursal" => "Fase", "venta" => 24193.40, "compra" => 9863.394000],
            ["family" => "Basico", "sucursal" => "Carranza", "venta" => 63716.50, "compra" => 19347.543000],
            ["family" => "Basico", "sucursal" => "Telaviv", "venta" => 25782.70, "compra" => 8287.116000],
            ["family" => "Basico", "sucursal" => "Hermosillo", "venta" => 34394.10, "compra" => 11842.548000],
            ["family" => "Basico", "sucursal" => "Oaxaca", "venta" => 28798.70, "compra" => 9854.331000],
            ["family" => "Basico", "sucursal" => "San Luis 2", "venta" => 40784.10, "compra" => 12728.034000],
            ["family" => "Basico", "sucursal" => "Loa", "venta" => 36127.50, "compra" => 8586.144000],
            ["family" => "Blusa", "sucursal" => "Morelos", "venta" => 148144.70, "compra" => 58753.664000],
            ["family" => "Blusa", "sucursal" => "San Luis 3", "venta" => 740690.60, "compra" => 285295.747500],
            ["family" => "Blusa", "sucursal" => "Oaxaca", "venta" => 123978.40, "compra" => 51387.731000],
            ["family" => "Blusa", "sucursal" => "San Luis 2", "venta" => 270066.70, "compra" => 99376.162500],
            ["family" => "Blusa", "sucursal" => "Carranza", "venta" => 679412.85, "compra" => 278120.518500],
            ["family" => "Blusa", "sucursal" => "Glamour", "venta" => 115305.50, "compra" => 52060.966000],
            ["family" => "Blusa", "sucursal" => "San Luis 1", "venta" => 190588.50, "compra" => 70113.334500],
            ["family" => "Blusa", "sucursal" => "Maluk", "venta" => 914018.80, "compra" => 352622.076700],
            ["family" => "Blusa", "sucursal" => "Loa", "venta" => 133517.20, "compra" => 55323.828000],
            ["family" => "Blusa", "sucursal" => "Galerias", "venta" => 285616.70, "compra" => 100139.854500],
            ["family" => "Blusa", "sucursal" => "Fase", "venta" => 137055.20, "compra" => 48888.971000],
            ["family" => "Blusa", "sucursal" => "Telaviv", "venta" => 82435.50, "compra" => 43454.165000],
            ["family" => "Blusa", "sucursal" => "Hermosillo", "venta" => 182006.66, "compra" => 68357.987000],
            ["family" => "Blusa", "sucursal" => "Mia", "venta" => 246537.00, "compra" => 97206.004500],
            ["family" => "Bodysuit", "sucursal" => "Oaxaca", "venta" => 510.00, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Morelos", "venta" => 1456.50, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Glamour", "venta" => 414.60, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Fase", "venta" => 1180.20, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Carranza", "venta" => 33784.80, "compra" => 8102.911500],
            ["family" => "Bodysuit", "sucursal" => "Mia", "venta" => 3482.40, "compra" => 1300.137000],
            ["family" => "Bodysuit", "sucursal" => "Loa", "venta" => 930.50, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Maluk", "venta" => 31360.40, "compra" => 9931.861500],
            ["family" => "Bodysuit", "sucursal" => "Hermosillo", "venta" => 1469.20, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "San Luis 1", "venta" => 5632.40, "compra" => 346.437000],
            ["family" => "Bodysuit", "sucursal" => "Galerias", "venta" => 4030.10, "compra" => 1300.137000],
            ["family" => "Bodysuit", "sucursal" => "San Luis 3", "venta" => 27811.50, "compra" => 9258.661500],
            ["family" => "Bodysuit", "sucursal" => "San Luis 2", "venta" => 4794.90, "compra" => 1300.137000],
            ["family" => "Bodysuit", "sucursal" => "Telaviv", "venta" => 1047.00, "compra" => 0.000000],
            ["family" => "Chamarra", "sucursal" => "San Luis 3", "venta" => 150299.20, "compra" => 29839.050000],
            ["family" => "Chamarra", "sucursal" => "San Luis 2", "venta" => 48215.10, "compra" => 4658.550000],
            ["family" => "Chamarra", "sucursal" => "Glamour", "venta" => 10570.60, "compra" => 781.650000],
            ["family" => "Chamarra", "sucursal" => "Telaviv", "venta" => 8585.50, "compra" => 0.000000],
            ["family" => "Chamarra", "sucursal" => "Maluk", "venta" => 142041.90, "compra" => 60502.545600],
            ["family" => "Chamarra", "sucursal" => "Oaxaca", "venta" => 9448.50, "compra" => 781.650000],
            ["family" => "Chamarra", "sucursal" => "Hermosillo", "venta" => 20005.20, "compra" => 781.650000],
            ["family" => "Chamarra", "sucursal" => "Mia", "venta" => 38179.50, "compra" => 4658.550000],
            ["family" => "Chamarra", "sucursal" => "Carranza", "venta" => 162128.30, "compra" => 29839.050000],
            ["family" => "Chamarra", "sucursal" => "San Luis 1", "venta" => 30521.10, "compra" => 4658.550000],
            ["family" => "Chamarra", "sucursal" => "Morelos", "venta" => 22693.90, "compra" => 781.650000],
            ["family" => "Chamarra", "sucursal" => "Fase", "venta" => 11510.90, "compra" => 781.650000],
            ["family" => "Chamarra", "sucursal" => "Galerias", "venta" => 43034.80, "compra" => 5502.270000],
            ["family" => "Chamarra", "sucursal" => "Loa", "venta" => 24373.00, "compra" => 3153.150000],
            ["family" => "Falda", "sucursal" => "Mia", "venta" => 42569.70, "compra" => 20341.305000],
            ["family" => "Falda", "sucursal" => "Hermosillo", "venta" => 11938.00, "compra" => 2454.075000],
            ["family" => "Falda", "sucursal" => "Loa", "venta" => 8767.30, "compra" => 4322.250000],
            ["family" => "Falda", "sucursal" => "San Luis 2", "venta" => 44129.10, "compra" => 21079.215000],
            ["family" => "Falda", "sucursal" => "Fase", "venta" => 4763.70, "compra" => 1216.800000],
            ["family" => "Falda", "sucursal" => "Glamour", "venta" => 4480.70, "compra" => 1216.800000],
            ["family" => "Falda", "sucursal" => "Telaviv", "venta" => 4685.30, "compra" => 1216.800000],
            ["family" => "Falda", "sucursal" => "Carranza", "venta" => 113016.40, "compra" => 58560.150600],
            ["family" => "Falda", "sucursal" => "Morelos", "venta" => 6623.50, "compra" => 2454.075000],
            ["family" => "Falda", "sucursal" => "Galerias", "venta" => 53790.70, "compra" => 22759.665000],
            ["family" => "Falda", "sucursal" => "Oaxaca", "venta" => 5116.00, "compra" => 2454.075000],
            ["family" => "Falda", "sucursal" => "Maluk", "venta" => 158910.40, "compra" => 75412.740600],
            ["family" => "Falda", "sucursal" => "San Luis 3", "venta" => 113834.90, "compra" => 55891.560600],
            ["family" => "Falda", "sucursal" => "San Luis 1", "venta" => 20181.50, "compra" => 13848.750000],
            ["family" => "Kimono", "sucursal" => "Carranza", "venta" => 12657.00, "compra" => 6477.480000],
            ["family" => "Kimono", "sucursal" => "San Luis 3", "venta" => 10099.50, "compra" => 6477.480000],
            ["family" => "Kimono", "sucursal" => "San Luis 1", "venta" => 217.50, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Telaviv", "venta" => 335.00, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Maluk", "venta" => 14539.50, "compra" => 6477.480000],
            ["family" => "Kimono", "sucursal" => "Oaxaca", "venta" => 102.50, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Glamour", "venta" => 560.00, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Mia", "venta" => 1325.00, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Galerias", "venta" => 544.00, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "San Luis 2", "venta" => 4770.00, "compra" => 1562.085000],
            ["family" => "Monoshort", "sucursal" => "Telaviv", "venta" => 970.40, "compra" => 1507.500000],
            ["family" => "Monoshort", "sucursal" => "Fase", "venta" => 512.50, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Mia", "venta" => 487.50, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Galerias", "venta" => 1006.20, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "San Luis 3", "venta" => 41700.50, "compra" => 16170.546600],
            ["family" => "Monoshort", "sucursal" => "Glamour", "venta" => 1204.50, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Carranza", "venta" => 31558.90, "compra" => 16472.046600],
            ["family" => "Monoshort", "sucursal" => "San Luis 1", "venta" => 343.00, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Maluk", "venta" => 45077.40, "compra" => 18830.286600],
            ["family" => "Monoshort", "sucursal" => "Loa", "venta" => 2427.50, "compra" => 1989.000000],
            ["family" => "Monoshort", "sucursal" => "Hermosillo", "venta" => 1138.90, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Oaxaca", "venta" => 177.50, "compra" => 0.000000],
            ["family" => "Pantalon", "sucursal" => "Maluk", "venta" => 737962.20, "compra" => 281075.390800],
            ["family" => "Pantalon", "sucursal" => "Oaxaca", "venta" => 107451.20, "compra" => 35326.954500],
            ["family" => "Pantalon", "sucursal" => "San Luis 1", "venta" => 131474.10, "compra" => 56219.904000],
            ["family" => "Pantalon", "sucursal" => "Galerias", "venta" => 216080.70, "compra" => 85449.354000],
            ["family" => "Pantalon", "sucursal" => "Hermosillo", "venta" => 121737.00, "compra" => 52953.904500],
            ["family" => "Pantalon", "sucursal" => "Morelos", "venta" => 111881.90, "compra" => 43972.879500],
            ["family" => "Pantalon", "sucursal" => "San Luis 2", "venta" => 199040.60, "compra" => 77115.274800],
            ["family" => "Pantalon", "sucursal" => "Glamour", "venta" => 93144.90, "compra" => 37055.704500],
            ["family" => "Pantalon", "sucursal" => "Loa", "venta" => 110211.70, "compra" => 47583.934500],
            ["family" => "Pantalon", "sucursal" => "Mia", "venta" => 189384.90, "compra" => 72302.379000],
            ["family" => "Pantalon", "sucursal" => "Telaviv", "venta" => 78891.00, "compra" => 41311.492500],
            ["family" => "Pantalon", "sucursal" => "Carranza", "venta" => 481621.70, "compra" => 191638.050800],
            ["family" => "Pantalon", "sucursal" => "Fase", "venta" => 104317.30, "compra" => 39170.509500],
            ["family" => "Pantalon", "sucursal" => "San Luis 3", "venta" => 468917.60, "compra" => 206337.793800],
            ["family" => "Saco/Sueter", "sucursal" => "Maluk", "venta" => 62614.00, "compra" => 29967.180000],
            ["family" => "Saco/Sueter", "sucursal" => "Fase", "venta" => 8448.40, "compra" => 7642.800000],
            ["family" => "Saco/Sueter", "sucursal" => "Galerias", "venta" => 15639.60, "compra" => 9606.300000],
            ["family" => "Saco/Sueter", "sucursal" => "San Luis 2", "venta" => 16857.00, "compra" => 9606.300000],
            ["family" => "Saco/Sueter", "sucursal" => "Telaviv", "venta" => 7807.70, "compra" => 7179.600000],
            ["family" => "Saco/Sueter", "sucursal" => "San Luis 3", "venta" => 69558.60, "compra" => 29087.100000],
            ["family" => "Saco/Sueter", "sucursal" => "Carranza", "venta" => 75637.90, "compra" => 29087.100000],
            ["family" => "Saco/Sueter", "sucursal" => "Glamour", "venta" => 5739.90, "compra" => 7642.800000],
            ["family" => "Saco/Sueter", "sucursal" => "Loa", "venta" => 7863.90, "compra" => 4574.100000],
            ["family" => "Saco/Sueter", "sucursal" => "Morelos", "venta" => 10164.50, "compra" => 7642.800000],
            ["family" => "Saco/Sueter", "sucursal" => "San Luis 1", "venta" => 14094.40, "compra" => 7642.800000],
            ["family" => "Saco/Sueter", "sucursal" => "Oaxaca", "venta" => 10926.40, "compra" => 7179.600000],
            ["family" => "Saco/Sueter", "sucursal" => "Hermosillo", "venta" => 10262.30, "compra" => 7642.800000],
            ["family" => "Saco/Sueter", "sucursal" => "Mia", "venta" => 12443.10, "compra" => 9606.300000],
            ["family" => "Short", "sucursal" => "Loa", "venta" => 18652.10, "compra" => 9108.563400],
            ["family" => "Short", "sucursal" => "San Luis 1", "venta" => 22648.70, "compra" => 8815.945200],
            ["family" => "Short", "sucursal" => "Oaxaca", "venta" => 15059.70, "compra" => 7719.413400],
            ["family" => "Short", "sucursal" => "Galerias", "venta" => 33380.30, "compra" => 13908.818400],
            ["family" => "Short", "sucursal" => "Glamour", "venta" => 25393.90, "compra" => 6990.385200],
            ["family" => "Short", "sucursal" => "Telaviv", "venta" => 12676.40, "compra" => 6555.308400],
            ["family" => "Short", "sucursal" => "Fase", "venta" => 20360.80, "compra" => 10242.113400],
            ["family" => "Short", "sucursal" => "Morelos", "venta" => 21544.20, "compra" => 11249.528400],
            ["family" => "Short", "sucursal" => "Carranza", "venta" => 73173.20, "compra" => 25644.913800],
            ["family" => "Short", "sucursal" => "Hermosillo", "venta" => 26817.20, "compra" => 13155.788400],
            ["family" => "Short", "sucursal" => "San Luis 3", "venta" => 64117.10, "compra" => 22391.953800],
            ["family" => "Short", "sucursal" => "Maluk", "venta" => 101044.30, "compra" => 39457.933800],
            ["family" => "Short", "sucursal" => "San Luis 2", "venta" => 39554.80, "compra" => 14784.557400],
            ["family" => "Short", "sucursal" => "Mia", "venta" => 29167.10, "compra" => 13423.853400],
            ["family" => "Vestido", "sucursal" => "San Luis 3", "venta" => 297410.10, "compra" => 104785.773000],
            ["family" => "Vestido", "sucursal" => "Hermosillo", "venta" => 43668.10, "compra" => 17913.925000],
            ["family" => "Vestido", "sucursal" => "San Luis 1", "venta" => 28372.70, "compra" => 11889.150000],
            ["family" => "Vestido", "sucursal" => "San Luis 2", "venta" => 49988.50, "compra" => 19459.560000],
            ["family" => "Vestido", "sucursal" => "Carranza", "venta" => 245661.90, "compra" => 103699.843000],
            ["family" => "Vestido", "sucursal" => "Galerias", "venta" => 67948.60, "compra" => 29714.346000],
            ["family" => "Vestido", "sucursal" => "Mia", "venta" => 59952.50, "compra" => 26523.546000],
            ["family" => "Vestido", "sucursal" => "Telaviv", "venta" => 16619.20, "compra" => 13905.820000],
            ["family" => "Vestido", "sucursal" => "Oaxaca", "venta" => 25654.80, "compra" => 15430.270000],
            ["family" => "Vestido", "sucursal" => "Morelos", "venta" => 38724.05, "compra" => 18627.175000],
            ["family" => "Vestido", "sucursal" => "Maluk", "venta" => 413488.10, "compra" => 142709.369800],
            ["family" => "Vestido", "sucursal" => "Fase", "venta" => 32929.20, "compra" => 19503.970000],
            ["family" => "Vestido", "sucursal" => "Glamour", "venta" => 33347.00, "compra" => 18266.230000],
            ["family" => "Vestido", "sucursal" => "Loa", "venta" => 43908.60, "compra" => 23046.750000],
            ["family" => "Total", "sucursal" => "Carranza", "venta" => 1972369.45, "compra" => 766989.607800],
["family" => "Total", "sucursal" => "San Luis 2", "venta" => 718200.80, "compra" => 261669.875700],
["family" => "Total", "sucursal" => "Mia", "venta" => 666128.40, "compra" => 258078.990900],
["family" => "Total", "sucursal" => "Loa", "venta" => 386779.30, "compra" => 157687.719900],
["family" => "Total", "sucursal" => "Fase", "venta" => 345271.60, "compra" => 137310.207900],
["family" => "Total", "sucursal" => "Telaviv", "venta" => 239835.70, "compra" => 123417.801900],
["family" => "Total", "sucursal" => "Maluk", "venta" => 2675657.30, "compra" => 1032964.853400],
["family" => "Total", "sucursal" => "San Luis 3", "venta" => 2034819.70, "compra" => 781842.145800],
["family" => "Total", "sucursal" => "Hermosillo", "venta" => 453436.66, "compra" => 175102.677900],
["family" => "Total", "sucursal" => "Oaxaca", "venta" => 327223.70, "compra" => 130134.024900],
["family" => "Total", "sucursal" => "San Luis 1", "venta" => 467782.20, "compra" => 183492.017700],
["family" => "Total", "sucursal" => "Galerias", "venta" => 758024.10, "compra" => 281411.103900],
["family" => "Total", "sucursal" => "Morelos", "venta" => 392332.45, "compra" => 154743.846900],
["family" => "Total", "sucursal" => "Glamour", "venta" => 313685.40, "compra" => 133868.866700],
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
