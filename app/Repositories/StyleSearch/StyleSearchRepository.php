<?php
namespace App\Repositories\StyleSearch;

use Illuminate\Support\Facades\DB;

class StyleSearchRepository {
    public function getData(
        ?string $search = NULL){
        if($search == NULL) return collect([]);
        $sql = "EXEC dbo.DRSearchStylesPrices
        @style = :style;
        ";
        $resultSet = DB::connection('mssql')->selectResultSets($sql,[
            'style' => $search
        ]);

        return collect($resultSet[0] ?? collect([]));
    }
}
