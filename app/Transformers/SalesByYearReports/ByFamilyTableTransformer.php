<?php
namespace App\Transformers\SalesByYearReports;
use Illuminate\Support\Collection;

class ByFamilyTableTransformer{
    public function transform(Collection $rawData, Collection $families): array {
        $grouped = $rawData->groupBy('FamilyId');
        $years = $this->getYears($rawData);

        $byFamily = $grouped->map(function ($row,$key) use ($families, $years) {
            $familyId = $key;
            // Usamos Optional para evitar errores si no se encuentra el nombre
            $familyName = $families->where('FamilyId', $key)->first()->Name ?? 'Sin Nombre';
            $totalSale = $row->sum('Sale');
            $totalDiscount = $row->sum('Discount');
            $total_discount_percentage = ($totalSale + $totalDiscount) > 0 ? $totalDiscount / ($totalSale + $totalDiscount) * 100 : 0;
            $byYear = $years->map(function ($year) use ($row,$totalSale,$totalDiscount) {
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
            $base = [
                'FamilyId' => $familyId,
                'Name' => $familyName,
                'Sale' => $totalSale,
                'Total_discount_percentage' => $total_discount_percentage,
                'Discount' => $totalDiscount,
                'Years' => $byYear
            ];
            return $base;
        });
        return $byFamily->values()->toArray();
    }
    public function getYears(Collection $rawData): Collection {
        return collect($rawData->groupBy('Year')->keys()->toArray());
    }
}
