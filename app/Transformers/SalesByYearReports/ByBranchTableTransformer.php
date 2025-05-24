<?php
namespace App\Transformers\SalesByYearReports;
use Illuminate\Support\Collection;

class ByBranchTableTransformer {
    public function transform(Collection $rawData, Collection $branches): array {
        $grouped = $rawData->groupBy('BranchId');
        $years = $this->getYears($rawData);

        $byBranch = $grouped->map(function ($row,$key) use ($branches, $years) {
            $branchId = $key;
            $branchName = $branches->where('BranchId', $key)->first()->Name ?? 'Sin Nombre';
            $totalSale = $row->sum('Sale');
            $totalDiscount = $row->sum('Discount');
            $byYear = $years->map(function ($year) use ($row) {
                $sale = $row->where('Year', $year)->sum('Sale');
                $discount = $row->where('Year', $year)->sum('Discount');
                return [
                    'Year' => $year,
                    'Sale' => $sale,
                    'Discount' => $discount
                ];
            });
            $base = [
                'BranchId' => $branchId,
                'Name' => $branchName,
                'Sale' => $totalSale,
                'Discount' => $totalDiscount,
                'Years' => $byYear
            ];
            return $base;
        });
        return $byBranch->values()->toArray();
    }
    public function getYears(Collection $rawData): Collection {
        return collect($rawData->groupBy('Year')->keys()->toArray());
    }
}
