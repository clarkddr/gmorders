<?php
namespace App\Transformers\Performance;
use Illuminate\Support\Collection;

class ByCategoryTransformer{
    public function transform(Collection $rawDataByCategory)
    {
        $totalPurchase = $rawDataByCategory->sum('Purchase');
        $totalTotalSale = $rawDataByCategory->sum('TotalSale');
        $totalPurchaseVsSale = ($totalTotalSale > 0) ? ($totalPurchase / $totalTotalSale) * 100 : 0;
        $totalPurchaseSale = $rawDataByCategory->sum('PurchaseSale');
        $totalInventory = $rawDataByCategory->sum('Inventory');
        $performance = ($totalInventory > 0) ? ($totalPurchaseSale / $totalInventory) * 100 : 0;
        $results = [
            // Sacamos los GrandTotals para la fila de Footer
            'totalPurchaseSale' => $rawDataByCategory->sum('PurchaseSale'),
            'totalOtherSale' => $rawDataByCategory->sum('OtherSale'),
            'totalTotalSale' => $rawDataByCategory->sum('TotalSale'),
            'totalPurchaseDiscount' => $rawDataByCategory->sum('PurchaseDiscount'),
            'totalOtherDiscount' => $rawDataByCategory->sum('OtherDiscount'),
            'totalTotalDiscount' => $rawDataByCategory->sum('TotalDiscount'),
            'totalPurchase' => $rawDataByCategory->sum('Purchase'),
            'totalInventory' => $rawDataByCategory->sum('Inventory'),
            'totalPurchaseVsSale' => $totalPurchaseVsSale,
            'totalPerformance' => $performance,
            'categories' => $rawDataByCategory->map(function($category){
                $purchase = $category->Purchase;
                $totalSale = $category->TotalSale;
                $purchaseVsSale = ($totalSale > 0) ? ($purchase / $totalSale) * 100 : 0;
                $inventory = $category->Inventory;
                $sale = $category->PurchaseSale;
                $performance = ($inventory > 0) ? ($sale / $inventory) * 100 : 0;
                return [
                    'categoryid' => $category->CategoryId,
                    'categoryname' => $category->CategoryName,
                    'purchaseSale' => $category->PurchaseSale,
                    'otherSale' => $category->OtherSale,
                    'totalSale' => $category->TotalSale,
                    'purchaseDiscount' => $category->PurchaseDiscount,
                    'otherDiscount' => $category->OtherDiscount,
                    'totalDiscount' => $category->TotalDiscount,
                    'purchase' => $category->Purchase,
                    'inventory' => $category->Inventory,
                    'purchaseVsSale' => $purchaseVsSale,
                    'performance' => $performance,
                    //'branches' => $rawDataDetail->where('familyid', $family->familyid),
                ];
            }),
        ];


        return collect($results);






    }
}
