<?php
namespace App\Repositories\StyleSearchInventory;

use Illuminate\Support\Facades\DB;

class StyleSearchInventoryRepository {
    public function fetchData(
        ?string $search = NULL, int $branchid = 0){
        if($search == NULL) return collect([]);
        $sql = "EXEC dbo.DRSearchStylesPricesExistence
        @style = :style,
        @branchid = :branchid
        ";
        $resultSet = DB::connection('mssql')->selectResultSets($sql,[
            'style' => $search,
            'branchid' => $branchid
        ]);

        return collect($resultSet[0] ?? collect([]));
    }
}
