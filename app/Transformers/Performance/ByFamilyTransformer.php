<?php
namespace App\Transformers\Performance;
use Illuminate\Support\Collection;

class ByFamilyTransformer{
    public function transform(Collection $rawDataByFamily,)
    {
        $totalPurchaseSale = $rawDataByFamily->sum('PurchaseSale');
        $totalOtherSale = $rawDataByFamily->sum('OtherSale');
        $totalTotalSale = $rawDataByFamily->sum('TotalSale');
        $totalPurchaseDiscount = $rawDataByFamily->sum('PurchaseDiscount');
        $totalOtherDiscount = $rawDataByFamily->sum('OtherDiscount');
        $totalTotalDiscount = $rawDataByFamily->sum('TotalDiscount');
        $totalPurchase = $rawDataByFamily->sum('Purchase');
        $totalInventory = $rawDataByFamily->sum('Inventory');
        $totalPurchaseVsSale = ($totalTotalSale > 0) ? ($totalPurchase / $totalTotalSale) * 100 : 0;
        $performance = ($totalInventory > 0) ? ($totalPurchaseSale / $totalInventory) * 100 : 0;
        $totalPurchaseSaleRelation = $totalTotalSale > 0 ? ($totalPurchaseSale / $totalTotalSale) * 100 : 0;
        $totalOtherSaleRelation = $totalTotalSale > 0 ? ($totalOtherSale / $totalTotalSale) * 100 : 0;
        $totalPurchaseDiscountRelation =  $totalPurchaseSale > 0 ? ($totalPurchaseDiscount / $totalPurchaseSale) * 100 : 0;
        $totalOtherDiscountRelation = $totalOtherSale > 0 ? ($totalOtherDiscount / $totalOtherSale) * 100 : 0;
        $totalTotalDiscountRelation = $totalTotalSale > 0 ? ($totalTotalDiscount / $totalTotalSale) * 100 : 0;
        $results = [
            // Sacamos los GrandTotals para la fila de Footer
            'totalPurchaseSale' => $totalPurchaseSale,
            'totalOtherSale' => $totalOtherSale,
            'totalTotalSale' => $totalTotalSale,
            'totalPurchaseDiscount' => $totalPurchaseDiscount,
            'totalOtherDiscount' => $totalOtherDiscount,
            'totalTotalDiscount' => $totalTotalDiscount,
            'totalPurchase' => $totalPurchase,
            'totalInventory' => $totalInventory,
            'totalPurchaseVsSale' => $totalPurchaseVsSale,
            'totalPerformance' => $performance,
            'totalPurchaseSaleRelation' => $totalPurchaseSaleRelation,
            'totalOtherSaleRelation' => $totalOtherSaleRelation,
            'totalPurchaseDiscountRelation' => $totalPurchaseDiscountRelation,
            'totalOtherDiscountRelation' => $totalOtherDiscountRelation,
            'totalTotalDiscountRelation' => $totalTotalDiscountRelation,
            'families' => $rawDataByFamily->map(function($family){
                $purchaseSale = $family->PurchaseSale;
                $otherSale = $family->OtherSale;
                $totalSale = $family->TotalSale;
                $purchaseDiscount = $family->PurchaseDiscount;
                $otherDiscount = $family->OtherDiscount;
                $totalDiscount = $family->TotalDiscount;
                $purchaseSaleRelation = ($totalSale > 0) ? ($purchaseSale / $totalSale) * 100 : 0;
                $otherSaleRelation = ($totalSale > 0) ? ($otherSale / $totalSale) * 100 : 0;
                $purchaseDiscountRelation = ($purchaseSale > 0) ? ($purchaseDiscount / $purchaseSale) * 100 : 0;
                $otherDiscountRelation = ($otherSale > 0) ? ($otherDiscount / $otherSale) * 100 : 0;
                $totalDiscountRelation = ($totalSale > 0) ? ($totalDiscount / $totalSale) * 100 : 0;
                $purchase = $family->Purchase;
                $inventory = $family->Inventory;
                $purchaseVsSale = ($totalSale > 0) ? ($purchase / $totalSale) * 100 : 0;
                $performance = ($inventory > 0) ? ($purchaseSale / $inventory) * 100 : 0;
                return [
                    'familyid' => $family->familyid,
                    'familyname' => $family->FamilyName,
                    'purchaseSale' => $purchaseSale,
                    'otherSale' => $otherSale,
                    'totalSale' => $totalSale,
                    'purchaseDiscount' => $purchaseDiscount,
                    'otherDiscount' => $otherDiscount,
                    'totalDiscount' => $totalDiscount,
                    'purchase' => $purchase,
                    'inventory' => $inventory,
                    'purchaseVsSale' => $purchaseVsSale,
                    'performance' => $performance,
                    'purchaseSaleRelation' => $purchaseSaleRelation,
                    'otherSaleRelation' => $otherSaleRelation,
                    'purchaseDiscountRelation' => $purchaseDiscountRelation,
                    'otherDiscountRelation' => $otherDiscountRelation,
                    'totalDiscountRelation' => $totalDiscountRelation
                ];
            }),
        ];


        return collect($results);






    }
}
