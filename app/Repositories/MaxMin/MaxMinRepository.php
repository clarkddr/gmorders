<?php
namespace App\Repositories\MaxMin;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Throwable;

class MaxMinRepository {

    public function searchStyles( String $code) {
        try {
            $sql = "EXEC dbo.DRSearchStylesMaxMin
            @query = :query";
            $queryResults = DB::connection('mssql')->selectResultSets($sql,[
                'query' => $code
            ]);
        } catch (Throwable $e){
            report($e);
            return collect();
        }

        return collect($queryResults[0] ?? []);

    }
}
