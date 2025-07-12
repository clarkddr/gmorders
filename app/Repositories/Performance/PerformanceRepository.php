<?php
namespace App\Repositories\Performance;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PerformanceRepository {

    public function getPerformanceData(
        Carbon $saleFrom, Carbon $saleTo,
        Carbon $purchaseFrom, Carbon $purchaseTo,
        int $branchid = 0, int $familyid = 0,
        int $categoryid = 0, int $supplierid = 0
    ) {
        $query = "EXEC dbo.DRPerformance
        @saleFrom = :saleFrom,
        @saleTo = :saleTo,
        @purchaseFrom = :purchaseFrom,
        @purchaseTo = :purchaseTo,
        @branchid = :branchid, @familyid = :familyid,
        @categoryid = :categoryid, @supplierid = :supplierid";
        $queryResults = DB::connection('mssql')->selectResultSets($query,[
            'saleFrom' => $saleFrom->format('Y-m-d'),
            'saleTo' => $saleTo->format('Y-m-d'),
            'purchaseFrom' => $purchaseFrom->format('Y-m-d'),
            'purchaseTo' => $purchaseTo->format('Y-m-d'),
            'supplierid' => $supplierid,
            'branchid' => $branchid,
            'familyid' => $familyid,
            'categoryid' => $categoryid
        ]);

        return [
            'byCategory' => collect($queryResults[0] ?? []),
            'byFamily' => collect($queryResults[1] ?? []),
            'byBranch' => collect($queryResults[2] ?? []),
            'bySupplier' => collect($queryResults[4] ?? []),
            'results' => collect($queryResults[3] ?? []),
        ];
    }
}
