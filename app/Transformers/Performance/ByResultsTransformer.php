<?php
namespace App\Transformers\Performance;
use Illuminate\Support\Collection;

class ByResultsTransformer{
    public function transform(Collection $rawDataByResults)
    {
        $totalPurchase = $rawDataByResults->sum('Purchase');
        $totalTotalSale = $rawDataByResults->sum('TotalSale');
        $totalPurchaseVsSale = ($totalTotalSale > 0) ? ($totalPurchase / $totalTotalSale) * 100 : 0;
        $totalPurchaseSale = $rawDataByResults->sum('PurchaseSale');
        $totalInventory = $rawDataByResults->sum('Inventory');
        $performance = ($totalInventory > 0) ? ($totalPurchaseSale / $totalInventory) * 100 : 0;
        $results = [
            // Sacamos los GrandTotals para la fila de Footer
            'totalPurchaseSale' => $rawDataByResults->sum('PurchaseSale'),
            'totalOtherSale' => $rawDataByResults->sum('OtherSale'),
            'totalTotalSale' => $rawDataByResults->sum('TotalSale'),
            'totalPurchaseDiscount' => $rawDataByResults->sum('PurchaseDiscount'),
            'totalOtherDiscount' => $rawDataByResults->sum('OtherDiscount'),
            'totalTotalDiscount' => $rawDataByResults->sum('TotalDiscount'),
            'totalPurchase' => $rawDataByResults->sum('Purchase'),
            'totalInventory' => $rawDataByResults->sum('Inventory'),
            'totalPurchaseVsSale' => $totalPurchaseVsSale,
            'totalPerformance' => $performance,
            'results' => $rawDataByResults->map(function($row){
                $purchase = $row->Purchase;
                $totalSale = $row->TotalSale;
                $purchaseVsSale = ($totalSale > 0) ? ($purchase / $totalSale) * 100 : 0;
                $inventory = $row->Inventory;
                $sale = $row->PurchaseSale;
                $performance = ($inventory > 0) ? ($sale / $inventory) * 100 : 0;
                return [
                    'familyid' => $row->familyid,
                    'branchid' => $row->branchid,
                    'familyname' => $row->FamilyName,
                    'branchname' => $row->BranchName,
                    'purchaseSale' => $row->PurchaseSale,
                    'otherSale' => $row->OtherSale,
                    'totalSale' => $row->TotalSale,
                    'purchaseDiscount' => $row->PurchaseDiscount,
                    'otherDiscount' => $row->OtherDiscount,
                    'totalDiscount' => $row->TotalDiscount,
                    'purchase' => $row->Purchase,
                    'inventory' => $row->Inventory,
                    'purchaseVsSale' => $purchaseVsSale,
                    'performance' => $performance,
                ];
            }),
        ];
        return collect($results);

    }
}
