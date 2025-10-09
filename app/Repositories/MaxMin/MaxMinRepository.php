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

    public function MaxminPzByBranch(String $maxmins, Carbon $fromDate, int $branchid = 0){
        try {
            $sql = "EXEC dbo.DRCountPzByBranchMaxMin
            @PairsJson = :maxmins,
            @FromDate = :fromDate,
            @branch = :branchid";
            $queryResults = DB::connection('mssql')->selectResultSets($sql,[
                'maxmins' => $maxmins,
                'fromDate' => $fromDate->format('Y-m-d'),
                'branchid' => $branchid
            ]);
        } catch (Throwable $e){
            report($e);
            return collect();
        }
        return [
            'detail' => collect($queryResults[0] ?? []),
            'total' => collect($queryResults[1] ?? [])
        ];

    }
}
