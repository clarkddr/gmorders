<?php
namespace App\Repositories\ExpensesResults;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Throwable;

class ExpensesResultsRepository {
    public function getData( String $from, String $to){
        try {
            $sql = "EXEC dbo.DRExpensesResults
            @fromLocal = :fromLocal,
            @to = :to";
            $queryResults = DB::connection('mssql')->selectResultSets($sql,[
                'fromLocal' => $from,
                'to' => $to
            ]);
        } catch (Throwable $e){
            report($e);
            return collect();
        }

        return collect([
            'total' => collect($queryResults[0] ?? []),
            'byType' => collect($queryResults[1] ?? []),
            'byBranch' => collect($queryResults[2] ?? []),
            'bySubcategory' => collect($queryResults[3] ?? []),
            'administratives' => collect($queryResults[4] ?? []),
            'diverses' => collect($queryResults[5] ?? []),
            'detail' => collect($queryResults[6] ?? [])
        ]);
    }
}
