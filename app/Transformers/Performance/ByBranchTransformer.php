<?php
namespace App\Transformers\Performance;
use Illuminate\Support\Collection;

class ByBranchTransformer{
    public function transform(Collection $rawDataByBranch)
    {
        $totalPurchase = $rawDataByBranch->sum('Purchase');
        $totalTotalSale = $rawDataByBranch->sum('TotalSale');
        $totalPurchaseVsSale = ($totalTotalSale > 0) ? ($totalPurchase / $totalTotalSale) * 100 : 0;
        $totalPurchaseSale = $rawDataByBranch->sum('PurchaseSale');
        $totalInventory = $rawDataByBranch->sum('Inventory');
        $performance = ($totalInventory > 0) ? ($totalPurchaseSale / $totalInventory) * 100 : 0;
        $results = [
            // Sacamos los GrandTotals para la fila de Footer
            'totalPurchaseSale' => $rawDataByBranch->sum('PurchaseSale'),
            'totalOtherSale' => $rawDataByBranch->sum('OtherSale'),
            'totalTotalSale' => $rawDataByBranch->sum('TotalSale'),
            'totalPurchaseDiscount' => $rawDataByBranch->sum('PurchaseDiscount'),
            'totalOtherDiscount' => $rawDataByBranch->sum('OtherDiscount'),
            'totalTotalDiscount' => $rawDataByBranch->sum('TotalDiscount'),
            'totalPurchase' => $rawDataByBranch->sum('Purchase'),
            'totalInventory' => $rawDataByBranch->sum('Inventory'),
            'totalPurchaseVsSale' => $totalPurchaseVsSale,
            'totalPerformance' => $performance,
            'branches' => $rawDataByBranch->map(function($branch){
                $purchase = $branch->Purchase;
                $totalSale = $branch->TotalSale;
                $purchaseVsSale = ($totalSale > 0) ? ($purchase / $totalSale) * 100 : 0;
                $inventory = $branch->Inventory;
                $sale = $branch->PurchaseSale;
                $performance = ($inventory > 0) ? ($sale / $inventory) * 100 : 0;
                return [
                    'branchid' => $branch->branchid,
                    'branchname' => $branch->BranchName,
                    'purchaseSale' => $branch->PurchaseSale,
                    'otherSale' => $branch->OtherSale,
                    'totalSale' => $branch->TotalSale,
                    'purchaseDiscount' => $branch->PurchaseDiscount,
                    'otherDiscount' => $branch->OtherDiscount,
                    'totalDiscount' => $branch->TotalDiscount,
                    'purchase' => $branch->Purchase,
                    'inventory' => $branch->Inventory,
                    'purchaseVsSale' => $purchaseVsSale,
                    'performance' => $performance,
                    //'branches' => $rawDataDetail->where('familyid', $family->familyid),
                ];
            }),
        ];


        return collect($results);






    }
}
