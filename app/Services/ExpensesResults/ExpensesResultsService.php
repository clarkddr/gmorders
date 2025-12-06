<?php
namespace App\Services\ExpensesResults;

use App\Models\Maxmin;
use App\Repositories\ExpensesResults\ExpensesResultsRepository;
use App\Repositories\MaxMin\MaxMinRepository;
use App\Repositories\Performance\PerformanceRepository;
use Carbon\Carbon;

class ExpensesResultsService {
    protected ExpensesResultsRepository $repository;

    public function __construct(ExpensesResultsRepository $repository) {
        $this->repository = $repository;
    }

    public function getData(string $from, String $to) {
        $rawReport = $this->repository->getData($from, $to);
        $rawReport['total'] = $rawReport['total']->map(function($item) {
            $item->P1 = number_format($item->P1, 0);
            $item->P2 = number_format($item->P2, 0);
            $item->P3 = number_format($item->P3, 0);
            $item->P1vsP2 = number_format($item->P1vsP2*100, 0);
            $item->P1vsP3 = number_format($item->P1vsP3*100, 0);
            return $item;
        });
        $rawReport['byType'] = $rawReport['byType']->map(function($item) {
            $item->P1 = number_format($item->P1, 0);
            $item->P2 = number_format($item->P2, 0);
            $item->P3 = number_format($item->P3, 0);
            $item->P1vsP2 = number_format($item->P1vsP2*100, 0);
            $item->P1vsP3 = number_format($item->P1vsP3*100, 0);
            return $item;
        });
        $rawReport['byBranch'] = $rawReport['byBranch']->map(function($item) {
            $item->P1 = number_format($item->P1, 0);
            $item->P2 = number_format($item->P2, 0);
            $item->P3 = number_format($item->P3, 0);
            $item->P1vsP2 = number_format($item->P1vsP2*100, 0);
            $item->P1vsP3 = number_format($item->P1vsP3*100, 0);
            return $item;
        });
        $rawReport['bySubcategory'] = $rawReport['bySubcategory']->map(function($item) {
            $item->P1 = number_format($item->P1, 0);
            $item->P2 = number_format($item->P2, 0);
            $item->P3 = number_format($item->P3, 0);
            $item->P1vsP2 = number_format($item->P1vsP2*100, 0);
            $item->P1vsP3 = number_format($item->P1vsP3*100, 0);
            return $item;
        });
        $rawReport['administratives'] = $rawReport['administratives']->map(function($item) {
            $item->P1 = number_format($item->P1, 0);
            $item->P2 = number_format($item->P2, 0);
            $item->P3 = number_format($item->P3, 0);
            $item->P1vsP2 = number_format($item->P1vsP2*100, 0);
            $item->P1vsP3 = number_format($item->P1vsP3*100, 0);
            return $item;
        });
        $rawReport['diverses'] = $rawReport['diverses']->map(function($item) {
            $item->P1 = number_format($item->P1, 0);
            $item->P2 = number_format($item->P2, 0);
            $item->P3 = number_format($item->P3, 0);
            $item->P1vsP2 = number_format($item->P1vsP2*100, 0);
            $item->P1vsP3 = number_format($item->P1vsP3*100, 0);
            return $item;
        });
        $rawReport['detail'] = $rawReport['detail']->map(function($item) {
            $item->AmountFormatted = number_format($item->Amount, 2);
            $item->Description = str_replace('¬†',' ', $item->Description);
            $item->Date = date('d-m-Y', strtotime($item->Date));
            return $item;
        });

        return collect($rawReport);
    }
}
