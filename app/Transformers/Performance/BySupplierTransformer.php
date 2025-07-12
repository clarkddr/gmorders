<?php
namespace App\Transformers\Performance;
use Illuminate\Support\Collection;

class BySupplierTransformer{
    public function transform(Collection $rawDataBySupplier)
    {
        $totalPurchase = $rawDataBySupplier->sum('Purchase');
        $totalTotalSale = $rawDataBySupplier->sum('TotalSale');
        $totalPurchaseVsSale = ($totalTotalSale > 0) ? ($totalPurchase / $totalTotalSale) * 100 : 0;
        $totalPurchaseSale = $rawDataBySupplier->sum('PurchaseSale');
        $totalInventory = $rawDataBySupplier->sum('Inventory');
        $performance = ($totalInventory > 0) ? ($totalPurchaseSale / $totalInventory) * 100 : 0;
        $results = [
            // Sacamos los GrandTotals para la fila de Footer
            'totalPurchaseSale' => $rawDataBySupplier->sum('PurchaseSale'),
            'totalOtherSale' => $rawDataBySupplier->sum('OtherSale'),
            'totalTotalSale' => $rawDataBySupplier->sum('TotalSale'),
            'totalPurchaseDiscount' => $rawDataBySupplier->sum('PurchaseDiscount'),
            'totalOtherDiscount' => $rawDataBySupplier->sum('OtherDiscount'),
            'totalTotalDiscount' => $rawDataBySupplier->sum('TotalDiscount'),
            'totalPurchase' => $rawDataBySupplier->sum('Purchase'),
            'totalInventory' => $rawDataBySupplier->sum('Inventory'),
            'totalPurchaseVsSale' => $totalPurchaseVsSale,
            'totalPerformance' => $performance,
            'suppliers' => $rawDataBySupplier->map(function($supplier){
                $purchase = $supplier->Purchase;
                $totalSale = $supplier->TotalSale;
                $purchaseVsSale = ($totalSale > 0) ? ($purchase / $totalSale) * 100 : 0;
                $inventory = $supplier->Inventory;
                $sale = $supplier->PurchaseSale;
                $performance = ($inventory > 0) ? ($sale / $inventory) * 100 : 0;
                return [
                    'supplierid' => $supplier->SupplierId,
                    'suppliername' => $supplier->SupplierName,
                    'purchaseSale' => $supplier->PurchaseSale,
                    'otherSale' => $supplier->OtherSale,
                    'totalSale' => $supplier->TotalSale,
                    'purchaseDiscount' => $supplier->PurchaseDiscount,
                    'otherDiscount' => $supplier->OtherDiscount,
                    'totalDiscount' => $supplier->TotalDiscount,
                    'purchase' => $supplier->Purchase,
                    'inventory' => $supplier->Inventory,
                    'purchaseVsSale' => $purchaseVsSale,
                    'performance' => $performance,
                ];
            }),
        ];
        return collect($results);

    }
}
