<?php
namespace App\Repositories\StylesResults;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StylesResultsRepository {
    public function getStylesResults(
        Carbon $from, Carbon $to,
        int $categoryId = 0, int $familyId = 0, int $subcategoryId = 0,
        int $branchId = 0, int $supplierId = 0,int $threshold = 50){
        $query = "EXEC dbo.DRStylesResults
        @from = :from, @to = :to,
        @category = :categoryId, @family = :familyId, @subcategory = :subcategoryId,
        @branch = :branchId, @supplier = :supplierId, @threshold = :threshold";

        $queryResults = DB::connection('mssql')->selectResultSets($query,[
            'from' => $from->format('Y-m-d'),
            'to' => $to->format('Y-m-d'),
            'categoryId' => $categoryId,
            'familyId' => $familyId,
            'subcategoryId' => $subcategoryId,
            'branchId' => $branchId,
            'supplierId' => $supplierId,
            'threshold' => $threshold
        ]);

        return [
            'stylesResultsDetail' => collect($queryResults[0] ?? []),
            'stylesResults' => collect($queryResults[1] ?? [])
        ];
    }
}
