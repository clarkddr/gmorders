<?php
namespace App\Repositories\SalesByYearReports;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TotalizedSalesReportRepository {

    public function getYearSalesDiscounts(Carbon $from, Carbon $to, int $branchid = 0, int $familyid = 0, int $categoryid = 0) {
        $query = "EXEC dbo.DRSalesDiscountsByYearAndWeek2Years
        @FromLocal = :from,
        @ToLocal = :to,
        @branchid = :branchid, @familyid = :familyid, @categoryid = :categoryid";
        $queryResults = DB::connection('mssql')->selectResultSets($query,[
            'from' => $from->format('Y-m-d'),
            'to' => $to->format('Y-m-d'),
            'branchid' => $branchid,
            'familyid' => $familyid,
            'categoryid' => $categoryid
        ]);
        return [
            'weeklySales' => collect($queryResults[0] ?? []),
            'salesDiscountsByFamily' => collect($queryResults[1] ?? []),
            'salesDiscountsByBranch' => collect($queryResults[2] ?? [])
        ];
    }
}
