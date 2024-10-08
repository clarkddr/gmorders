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
<<<<<<< HEAD
            ["family" => "Basico", "sucursal" => "San Luis 1", "venta" => 25319.70, "compra" => 15260.787000],
            ["family" => "Basico", "sucursal" => "Mia", "venta" => 42986.70, "compra" => 18816.681000],
            ["family" => "Basico", "sucursal" => "Loa", "venta" => 36127.50, "compra" => 14280.609000],
            ["family" => "Basico", "sucursal" => "Telaviv", "venta" => 26025.70, "compra" => 13199.931000],
            ["family" => "Basico", "sucursal" => "San Luis 3", "venta" => 52600.10, "compra" => 28115.184000],
            ["family" => "Basico", "sucursal" => "Oaxaca", "venta" => 29848.10, "compra" => 15548.796000],
            ["family" => "Basico", "sucursal" => "Carranza", "venta" => 65532.50, "compra" => 31547.073000],
            ["family" => "Basico", "sucursal" => "Maluk", "venta" => 55490.50, "compra" => 28582.818000],
            ["family" => "Basico", "sucursal" => "Hermosillo", "venta" => 35856.60, "compra" => 17146.188000],
            ["family" => "Basico", "sucursal" => "Galerias", "venta" => 38048.10, "compra" => 19130.124000],
            ["family" => "Basico", "sucursal" => "Glamour", "venta" => 24546.80, "compra" => 15548.796000],
            ["family" => "Basico", "sucursal" => "Fase", "venta" => 24804.90, "compra" => 15557.859000],
            ["family" => "Basico", "sucursal" => "San Luis 2", "venta" => 42948.80, "compra" => 18827.799000],
            ["family" => "Basico", "sucursal" => "Morelos", "venta" => 32175.70, "compra" => 16956.540000],
            ["family" => "Blusa", "sucursal" => "Telaviv", "venta" => 84080.90, "compra" => 45665.945000],
            ["family" => "Blusa", "sucursal" => "San Luis 1", "venta" => 195289.30, "compra" => 73263.094500],
            ["family" => "Blusa", "sucursal" => "Mia", "venta" => 258891.50, "compra" => 101259.004500],
            ["family" => "Blusa", "sucursal" => "San Luis 2", "venta" => 285579.90, "compra" => 103429.162500],
            ["family" => "Blusa", "sucursal" => "Oaxaca", "venta" => 130109.20, "compra" => 53599.511000],
            ["family" => "Blusa", "sucursal" => "Morelos", "venta" => 152156.90, "compra" => 61295.474000],
            ["family" => "Blusa", "sucursal" => "San Luis 3", "venta" => 772235.60, "compra" => 303864.277500],
            ["family" => "Blusa", "sucursal" => "Maluk", "venta" => 968173.70, "compra" => 371769.606700],
            ["family" => "Blusa", "sucursal" => "Galerias", "venta" => 297816.90, "compra" => 104192.854500],
            ["family" => "Blusa", "sucursal" => "Hermosillo", "venta" => 189263.66, "compra" => 70899.797000],
            ["family" => "Blusa", "sucursal" => "Glamour", "venta" => 118648.10, "compra" => 54602.776000],
            ["family" => "Blusa", "sucursal" => "Fase", "venta" => 141152.60, "compra" => 51430.781000],
            ["family" => "Blusa", "sucursal" => "Carranza", "venta" => 707530.65, "compra" => 296689.048500],
            ["family" => "Blusa", "sucursal" => "Loa", "venta" => 138430.60, "compra" => 57865.638000],
=======
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
>>>>>>> parent of adea7bf (Se guardan cambios antes de integrar Proyeccion y DB Branix)
            ["family" => "Bodysuit", "sucursal" => "Oaxaca", "venta" => 510.00, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Glamour", "venta" => 414.60, "compra" => 0.000000],
<<<<<<< HEAD
            ["family" => "Bodysuit", "sucursal" => "Loa", "venta" => 930.50, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Mia", "venta" => 4448.40, "compra" => 1300.137000],
            ["family" => "Bodysuit", "sucursal" => "Fase", "venta" => 1180.20, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "San Luis 1", "venta" => 5845.10, "compra" => 346.437000],
            ["family" => "Bodysuit", "sucursal" => "Carranza", "venta" => 35452.50, "compra" => 8102.911500],
            ["family" => "Bodysuit", "sucursal" => "Hermosillo", "venta" => 1516.90, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Maluk", "venta" => 33785.10, "compra" => 9931.861500],
            ["family" => "Bodysuit", "sucursal" => "Telaviv", "venta" => 1047.00, "compra" => 0.000000],
            ["family" => "Bodysuit", "sucursal" => "Galerias", "venta" => 4289.10, "compra" => 1300.137000],
            ["family" => "Bodysuit", "sucursal" => "San Luis 3", "venta" => 29561.50, "compra" => 9258.661500],
            ["family" => "Bodysuit", "sucursal" => "San Luis 2", "venta" => 5199.10, "compra" => 1300.137000],
            ["family" => "Chamarra", "sucursal" => "Carranza", "venta" => 169892.40, "compra" => 58719.570000],
            ["family" => "Chamarra", "sucursal" => "Telaviv", "venta" => 8585.50, "compra" => 0.000000],
            ["family" => "Chamarra", "sucursal" => "Morelos", "venta" => 23554.80, "compra" => 5483.130000],
            ["family" => "Chamarra", "sucursal" => "Galerias", "venta" => 43329.30, "compra" => 13735.650000],
            ["family" => "Chamarra", "sucursal" => "San Luis 2", "venta" => 54266.30, "compra" => 12891.930000],
            ["family" => "Chamarra", "sucursal" => "Mia", "venta" => 40324.90, "compra" => 12312.930000],
            ["family" => "Chamarra", "sucursal" => "Fase", "venta" => 12243.90, "compra" => 5483.130000],
            ["family" => "Chamarra", "sucursal" => "Loa", "venta" => 25556.50, "compra" => 5422.830000],
            ["family" => "Chamarra", "sucursal" => "Glamour", "venta" => 11486.30, "compra" => 5483.130000],
            ["family" => "Chamarra", "sucursal" => "Maluk", "venta" => 152858.40, "compra" => 109954.935600],
            ["family" => "Chamarra", "sucursal" => "Hermosillo", "venta" => 20480.20, "compra" => 5483.130000],
            ["family" => "Chamarra", "sucursal" => "San Luis 1", "venta" => 33769.40, "compra" => 11154.930000],
            ["family" => "Chamarra", "sucursal" => "Oaxaca", "venta" => 9448.50, "compra" => 5483.130000],
            ["family" => "Chamarra", "sucursal" => "San Luis 3", "venta" => 159037.50, "compra" => 61440.870000],
            ["family" => "Falda", "sucursal" => "Hermosillo", "venta" => 12057.50, "compra" => 2454.075000],
            ["family" => "Falda", "sucursal" => "Fase", "venta" => 4881.20, "compra" => 1216.800000],
            ["family" => "Falda", "sucursal" => "Glamour", "venta" => 4809.70, "compra" => 1216.800000],
            ["family" => "Falda", "sucursal" => "Loa", "venta" => 9973.50, "compra" => 6493.500000],
            ["family" => "Falda", "sucursal" => "San Luis 1", "venta" => 22037.70, "compra" => 20391.450000],
            ["family" => "Falda", "sucursal" => "Telaviv", "venta" => 4685.30, "compra" => 1216.800000],
            ["family" => "Falda", "sucursal" => "Galerias", "venta" => 59835.60, "compra" => 29302.365000],
            ["family" => "Falda", "sucursal" => "Maluk", "venta" => 180981.10, "compra" => 82708.140600],
            ["family" => "Falda", "sucursal" => "Mia", "venta" => 46671.60, "compra" => 26884.005000],
            ["family" => "Falda", "sucursal" => "Morelos", "venta" => 6718.00, "compra" => 2454.075000],
            ["family" => "Falda", "sucursal" => "Carranza", "venta" => 119020.80, "compra" => 65855.550600],
            ["family" => "Falda", "sucursal" => "San Luis 3", "venta" => 119827.10, "compra" => 63186.960600],
            ["family" => "Falda", "sucursal" => "San Luis 2", "venta" => 46328.30, "compra" => 27621.915000],
            ["family" => "Falda", "sucursal" => "Oaxaca", "venta" => 5156.50, "compra" => 2454.075000],
            ["family" => "Kimono", "sucursal" => "Carranza", "venta" => 13231.00, "compra" => 6477.480000],
            ["family" => "Kimono", "sucursal" => "Telaviv", "venta" => 335.00, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "San Luis 1", "venta" => 217.50, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "San Luis 3", "venta" => 10099.50, "compra" => 6477.480000],
            ["family" => "Kimono", "sucursal" => "Oaxaca", "venta" => 102.50, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Maluk", "venta" => 14539.50, "compra" => 6477.480000],
            ["family" => "Kimono", "sucursal" => "Mia", "venta" => 1325.00, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Glamour", "venta" => 560.00, "compra" => 0.000000],
            ["family" => "Kimono", "sucursal" => "Galerias", "venta" => 544.00, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Telaviv", "venta" => 1139.40, "compra" => 1507.500000],
=======
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
>>>>>>> parent of adea7bf (Se guardan cambios antes de integrar Proyeccion y DB Branix)
            ["family" => "Monoshort", "sucursal" => "Fase", "venta" => 512.50, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "San Luis 2", "venta" => 5258.50, "compra" => 1562.085000],
            ["family" => "Monoshort", "sucursal" => "Mia", "venta" => 487.50, "compra" => 0.000000],
<<<<<<< HEAD
            ["family" => "Monoshort", "sucursal" => "Glamour", "venta" => 1204.50, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Carranza", "venta" => 31558.90, "compra" => 16472.046600],
            ["family" => "Monoshort", "sucursal" => "Galerias", "venta" => 1006.20, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "San Luis 1", "venta" => 343.00, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Oaxaca", "venta" => 177.50, "compra" => 0.000000],
            ["family" => "Monoshort", "sucursal" => "Loa", "venta" => 2427.50, "compra" => 1989.000000],
            ["family" => "Monoshort", "sucursal" => "Maluk", "venta" => 45423.90, "compra" => 18830.286600],
            ["family" => "Monoshort", "sucursal" => "San Luis 3", "venta" => 42245.50, "compra" => 17108.526600],
            ["family" => "Monoshort", "sucursal" => "Hermosillo", "venta" => 1138.90, "compra" => 0.000000],
            ["family" => "Pantalon", "sucursal" => "Oaxaca", "venta" => 113388.10, "compra" => 47277.514500],
            ["family" => "Pantalon", "sucursal" => "Morelos", "venta" => 117259.90, "compra" => 55923.439500],
            ["family" => "Pantalon", "sucursal" => "San Luis 3", "venta" => 503598.30, "compra" => 246395.908800],
            ["family" => "Pantalon", "sucursal" => "San Luis 1", "venta" => 136750.10, "compra" => 67617.519000],
            ["family" => "Pantalon", "sucursal" => "Hermosillo", "venta" => 124750.90, "compra" => 65295.289500],
            ["family" => "Pantalon", "sucursal" => "Maluk", "venta" => 789080.60, "compra" => 341104.952800],
            ["family" => "Pantalon", "sucursal" => "Telaviv", "venta" => 79537.50, "compra" => 52764.112500],
            ["family" => "Pantalon", "sucursal" => "Mia", "venta" => 200183.60, "compra" => 94217.529000],
            ["family" => "Pantalon", "sucursal" => "Loa", "venta" => 116049.50, "compra" => 56842.144500],
            ["family" => "Pantalon", "sucursal" => "Carranza", "venta" => 508153.90, "compra" => 223124.070800],
            ["family" => "Pantalon", "sucursal" => "Galerias", "venta" => 228502.50, "compra" => 111663.579000],
            ["family" => "Pantalon", "sucursal" => "Fase", "venta" => 109080.80, "compra" => 48428.719500],
            ["family" => "Pantalon", "sucursal" => "San Luis 2", "venta" => 209629.60, "compra" => 101143.774800],
            ["family" => "Pantalon", "sucursal" => "Glamour", "venta" => 95197.90, "compra" => 49397.089500],
            ["family" => "Saco/Sueter", "sucursal" => "Glamour", "venta" => 7036.60, "compra" => 8771.850000],
            ["family" => "Saco/Sueter", "sucursal" => "Mia", "venta" => 13002.60, "compra" => 13340.850000],
            ["family" => "Saco/Sueter", "sucursal" => "Telaviv", "venta" => 7807.70, "compra" => 8308.650000],
            ["family" => "Saco/Sueter", "sucursal" => "Morelos", "venta" => 10908.70, "compra" => 8771.850000],
            ["family" => "Saco/Sueter", "sucursal" => "Oaxaca", "venta" => 11335.40, "compra" => 8308.650000],
            ["family" => "Saco/Sueter", "sucursal" => "San Luis 2", "venta" => 18364.40, "compra" => 13340.850000],
            ["family" => "Saco/Sueter", "sucursal" => "Fase", "venta" => 8448.40, "compra" => 8771.850000],
            ["family" => "Saco/Sueter", "sucursal" => "Maluk", "venta" => 72451.00, "compra" => 35322.930000],
            ["family" => "Saco/Sueter", "sucursal" => "Hermosillo", "venta" => 10666.20, "compra" => 8771.850000],
            ["family" => "Saco/Sueter", "sucursal" => "San Luis 3", "venta" => 77556.10, "compra" => 34442.850000],
            ["family" => "Saco/Sueter", "sucursal" => "Galerias", "venta" => 15752.10, "compra" => 13340.850000],
            ["family" => "Saco/Sueter", "sucursal" => "Carranza", "venta" => 78519.20, "compra" => 34442.850000],
            ["family" => "Saco/Sueter", "sucursal" => "Loa", "venta" => 8043.40, "compra" => 5703.150000],
            ["family" => "Saco/Sueter", "sucursal" => "San Luis 1", "venta" => 16212.80, "compra" => 11377.350000],
            ["family" => "Short", "sucursal" => "Morelos", "venta" => 22310.70, "compra" => 11484.023400],
            ["family" => "Short", "sucursal" => "San Luis 2", "venta" => 40341.80, "compra" => 15019.052400],
            ["family" => "Short", "sucursal" => "Oaxaca", "venta" => 16408.20, "compra" => 7719.413400],
            ["family" => "Short", "sucursal" => "Telaviv", "venta" => 12973.40, "compra" => 6789.803400],
            ["family" => "Short", "sucursal" => "Galerias", "venta" => 34178.30, "compra" => 14143.313400],
            ["family" => "Short", "sucursal" => "San Luis 1", "venta" => 23205.20, "compra" => 8815.945200],
            ["family" => "Short", "sucursal" => "Fase", "venta" => 21342.80, "compra" => 10242.113400],
            ["family" => "Short", "sucursal" => "Carranza", "venta" => 74685.10, "compra" => 25879.408800],
            ["family" => "Short", "sucursal" => "Loa", "venta" => 19671.30, "compra" => 9343.058400],
            ["family" => "Short", "sucursal" => "Hermosillo", "venta" => 27855.70, "compra" => 13155.788400],
            ["family" => "Short", "sucursal" => "San Luis 3", "venta" => 66484.30, "compra" => 22626.448800],
            ["family" => "Short", "sucursal" => "Mia", "venta" => 30238.10, "compra" => 13423.853400],
            ["family" => "Short", "sucursal" => "Maluk", "venta" => 103636.30, "compra" => 39457.933800],
            ["family" => "Short", "sucursal" => "Glamour", "venta" => 25689.40, "compra" => 7224.880200],
            ["family" => "Vestido", "sucursal" => "Hermosillo", "venta" => 45656.00, "compra" => 19980.955000],
            ["family" => "Vestido", "sucursal" => "Maluk", "venta" => 433879.50, "compra" => 158382.899800],
            ["family" => "Vestido", "sucursal" => "San Luis 3", "venta" => 312637.90, "compra" => 113436.033000],
            ["family" => "Vestido", "sucursal" => "Mia", "venta" => 62292.40, "compra" => 32614.626000],
            ["family" => "Vestido", "sucursal" => "Oaxaca", "venta" => 27283.30, "compra" => 17497.300000],
            ["family" => "Vestido", "sucursal" => "Fase", "venta" => 35859.90, "compra" => 21571.000000],
            ["family" => "Vestido", "sucursal" => "Telaviv", "venta" => 16870.70, "compra" => 15972.850000],
            ["family" => "Vestido", "sucursal" => "Galerias", "venta" => 75030.20, "compra" => 35805.426000],
            ["family" => "Vestido", "sucursal" => "Morelos", "venta" => 38966.05, "compra" => 20694.205000],
            ["family" => "Vestido", "sucursal" => "Glamour", "venta" => 34020.00, "compra" => 20333.260000],
            ["family" => "Vestido", "sucursal" => "San Luis 2", "venta" => 55113.40, "compra" => 25550.640000],
            ["family" => "Vestido", "sucursal" => "Loa", "venta" => 46203.10, "compra" => 25895.430000],
            ["family" => "Vestido", "sucursal" => "San Luis 1", "venta" => 31354.20, "compra" => 17980.230000],
            ["family" => "Vestido", "sucursal" => "Carranza", "venta" => 254774.80, "compra" => 112350.103000],
            ["family" => "Total", "sucursal" => "San Luis 3", "venta" => 2145883.40, "compra" => 906353.200800],
["family" => "Total", "sucursal" => "Oaxaca", "venta" => 343767.30, "compra" => 157888.389900],
["family" => "Total", "sucursal" => "Loa", "venta" => 403413.40, "compra" => 183835.359900],
["family" => "Total", "sucursal" => "San Luis 1", "venta" => 490344.00, "compra" => 226207.742700],
["family" => "Total", "sucursal" => "Morelos", "venta" => 405507.25, "compra" => 183062.736900],
["family" => "Total", "sucursal" => "Mia", "venta" => 700852.30, "compra" => 314169.615900],
["family" => "Total", "sucursal" => "Galerias", "venta" => 798332.30, "compra" => 342614.298900],
["family" => "Total", "sucursal" => "Fase", "venta" => 359507.20, "compra" => 162702.252900],
["family" => "Total", "sucursal" => "San Luis 2", "venta" => 763030.10, "compra" => 320687.345700],
["family" => "Total", "sucursal" => "Maluk", "venta" => 2850299.60, "compra" => 1202523.845400],
["family" => "Total", "sucursal" => "Carranza", "venta" => 2058351.75, "compra" => 879660.112800],
["family" => "Total", "sucursal" => "Glamour", "venta" => 323613.90, "compra" => 162578.581700],
["family" => "Total", "sucursal" => "Hermosillo", "venta" => 469242.56, "compra" => 203187.072900],
["family" => "Total", "sucursal" => "Telaviv", "venta" => 243088.10, "compra" => 145425.591900],
=======
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
>>>>>>> parent of adea7bf (Se guardan cambios antes de integrar Proyeccion y DB Branix)
        ]);

        $families = $rows->pluck('family')->unique();
        $minimum = 45;
        $maximum = 45;
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
