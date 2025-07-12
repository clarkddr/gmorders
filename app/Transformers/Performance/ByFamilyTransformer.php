<?php
namespace App\Transformers\Performance;
use Illuminate\Support\Collection;

class ByFamilyTransformer{
    public function transform(Collection $rawDataByFamily,)
    {
        $totalPurchase = $rawDataByFamily->sum('Purchase');
        $totalTotalSale = $rawDataByFamily->sum('TotalSale');
        $totalPurchaseVsSale = ($totalTotalSale > 0) ? ($totalPurchase / $totalTotalSale) * 100 : 0;
        $totalPurchaseSale = $rawDataByFamily->sum('PurchaseSale');
        $totalInventory = $rawDataByFamily->sum('Inventory');
        $performance = ($totalInventory > 0) ? ($totalPurchaseSale / $totalInventory) * 100 : 0;
        $results = [
            // Sacamos los GrandTotals para la fila de Footer
            'totalPurchaseSale' => $rawDataByFamily->sum('PurchaseSale'),
            'totalOtherSale' => $rawDataByFamily->sum('OtherSale'),
            'totalTotalSale' => $rawDataByFamily->sum('TotalSale'),
            'totalPurchaseDiscount' => $rawDataByFamily->sum('PurchaseDiscount'),
            'totalOtherDiscount' => $rawDataByFamily->sum('OtherDiscount'),
            'totalTotalDiscount' => $rawDataByFamily->sum('TotalDiscount'),
            'totalPurchase' => $rawDataByFamily->sum('Purchase'),
            'totalInventory' => $rawDataByFamily->sum('Inventory'),
            'totalPurchaseVsSale' => $totalPurchaseVsSale,
            'totalPerformance' => $performance,
            'families' => $rawDataByFamily->map(function($family){
                $purchase = $family->Purchase;
                $totalSale = $family->TotalSale;
                $purchaseVsSale = ($totalSale > 0) ? ($purchase / $totalSale) * 100 : 0;
                $inventory = $family->Inventory;
                $sale = $family->PurchaseSale;
                $performance = ($inventory > 0) ? ($sale / $inventory) * 100 : 0;
                return [
                    'familyid' => $family->familyid,
                    'familyname' => $family->FamilyName,
                    'purchaseSale' => $family->PurchaseSale,
                    'otherSale' => $family->OtherSale,
                    'totalSale' => $family->TotalSale,
                    'purchaseDiscount' => $family->PurchaseDiscount,
                    'otherDiscount' => $family->OtherDiscount,
                    'totalDiscount' => $family->TotalDiscount,
                    'purchase' => $family->Purchase,
                    'inventory' => $family->Inventory,
                    'purchaseVsSale' => $purchaseVsSale,
                    'performance' => $performance,
                    //'branches' => $rawDataDetail->where('familyid', $family->familyid),
                ];
            }),
        ];


        return collect($results);






    }
}
