<?php
namespace App\Transformers\SalesByYearReports;
use Illuminate\Support\Collection;

class ByBranchTableTransformer {
    public function transform(Collection $rawData, Collection $branches): array {
        $grouped = $rawData->groupBy('BranchId');
        $years = $this->getYears($rawData);
        // Sacamos los GrandTotals para la fila de Footer
        $grandSale = $rawData->sum('Sale');
        $grandDiscount = $rawData->sum('Discount');
        $byYear = $years->map(function($year) use ($rawData,$grandSale){
            $sale = $rawData->where('Year', $year)->sum('Sale');
            $discount = $rawData->where('Year', $year)->sum('Discount');
            return collect([
                'Year' => $year,
                'Sale' => $sale,
                'Discount' => $discount,
                'discount_percentage' => ($sale + $discount) > 0 ? $discount / ($sale + $discount) * 100 : 0,
                'sale_proportion' => $sale > 0 ? $sale / $grandSale * 100 : 0
            ]);
        });
        $totalRow = collect([
            'Years' => $byYear,
            'Sale' => $grandSale,
            'Discount' => $grandDiscount,
            'discount_percentage' => ($grandSale + $grandDiscount) > 0 ? $grandDiscount / ($grandSale + $grandDiscount) * 100 : 0,
        ]);


        $byBranch = $grouped->map(function ($row,$key) use ($branches, $years) {
            $branchId = $key;
            $branchName = $branches->where('BranchId', $key)->first()->Name ?? 'Sin Nombre';
            $totalSale = $row->sum('Sale');
            $totalDiscount = $row->sum('Discount');
            $total_discount_percentage = ($totalSale + $totalDiscount) > 0 ? $totalDiscount / ($totalSale + $totalDiscount) * 100 : 0;
            $byYear = $years->map(function ($year) use ($row, $totalSale, $totalDiscount) {
                $sale = $row->where('Year', $year)->sum('Sale');
                $discount = $row->where('Year', $year)->sum('Discount');
                return [
                    'Year' => $year,
                    'Sale' => $sale,
                    'Discount' => $discount,
                    'discount_percentage' => ($sale + $discount) > 0 ? $discount / ($sale + $discount) * 100 : 0,
                    'sale_proportion' => $totalSale > 0 ? $sale / $totalSale * 100 : 0,
                ];
            });
            $base = collect([
                'Years' => $byYear,
                'BranchId' => $branchId,
                'Name' => $branchName,
                'Sale' => $totalSale,
                'Discount' => $totalDiscount,
                'Total_discount_percentage' => $total_discount_percentage,
            ]);
            return $base;
        });
        return [
            'byBranch' => $byBranch,
            'totalRow' => $totalRow,
        ];
    }
    public function getYears(Collection $rawData): Collection {
        return collect($rawData->groupBy('Year')->keys()->sortDesc()->toArray());
    }
}
