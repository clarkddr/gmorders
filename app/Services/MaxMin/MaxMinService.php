<?php
namespace App\Services\MaxMin;

use App\Models\Maxmin;
use App\Repositories\MaxMin\MaxMinRepository;
use App\Repositories\Performance\PerformanceRepository;
use Carbon\Carbon;
use App\Models\Family;
use App\Models\Branch;
use App\Models\Category;
class MaxMinService {
    protected MaxMinRepository $repository;

    public function __construct(MaxMinRepository $repository) {
        $this->repository = $repository;
    }

    public function search(string $query) {
        $rawReport = $this->repository->searchStyles($query);
        $rawReport = $rawReport->map(function($style) {
            $style->DateFormatted = Carbon::parse($style->Date)->translatedFormat('d/m/Y');
            $style->DateFormatted = str_replace('.', '',$style->DateFormatted);
            return $style;

        });
        return collect($rawReport);
    }

    public function getMaxminPzByBranch(Carbon $fromDate,$branches, String $visibility = 'active') {
        $branchIds = [];
        foreach($branches as $branch) {
            $branchIds[] = $branch->BranchId;
        }

        $maxminBase = MaxMin::query()
            ->when($visibility === 'all', fn($q) => $q->withTrashed())
            ->when($visibility === 'archived', fn($q) => $q->onlyTrashed());


        $maxmins = $maxminBase
            ->with([
                'supplier','family','color','subcategory',
                'branches' => fn($q) => $q->whereIn('branch_id', $branchIds),
            ])
            ->withSum(['branches as total_max' => fn($q) => $q->whereIn('branch_id', $branchIds)], 'max')
            ->withSum(['branches as total_min' => fn($q) => $q->whereIn('branch_id', $branchIds)], 'min')
            ->whereHas('branches', fn($q) => $q->whereIn('branch_id', $branchIds))
            ->get();

        $pairs = $maxmins->map(function ($maxmin) {
            return [
                'maxminid' => $maxmin->id,
                'code' => $maxmin->code,
                'colorId' => $maxmin->ColorId,
                'subcategoryId' => $maxmin->SubcategoryId,
            ];
        });

        $pairsJson = json_encode($pairs, JSON_UNESCAPED_UNICODE);

        $branchesIdsSQl = count($branchIds) > 1 ? 0 : $branchIds[0];
        $rawReports = $this->repository->MaxminPzByBranch($pairsJson, $fromDate,$branchesIdsSQl);

        $results = $maxmins->map(function($maxmin) use ($rawReports,$branches) {
            $totalMax = $maxmin->total_max;
            $totalMin = $maxmin->total_min;
            $totalInventory = $rawReports['total']->firstWhere('MaxminId', $maxmin->id)->pz_total ?? 0;

            $branchDetails = $branches->map(function($branch) use ($rawReports,$maxmin) {
                $branchId = $branch->BranchId;
                $max = $maxmin->branches->firstWhere('branch_id', $branchId)->max ?? null;
                $min = $maxmin->branches->firstWhere('branch_id', $branchId)->min ?? null;
                $inventory = $rawReports['detail']->where('MaxminId', $maxmin->id)->where('BranchId', $branchId)->first()->pz ?? 0;
                $stockOut = !is_null($min) && $inventory <= $min ? 1 : 0;
                return collect([
                    'branch_id' => $branchId,
                    'name' => $branch->Name,
                    'min' => $min,
                    'max' => $max,
                    'inventory' => $inventory,
                    'stock_out' => $stockOut,
                ]);
            });

            $stockOutCount = $branchDetails->where('stock_out', true)->count();

            return collect([
                'id' => $maxmin->id,
                'code' => $maxmin->code,
                'supplier' => $maxmin->supplier->Name,
                'subcategory' => $maxmin->subcategory->Name,
                'color' => $maxmin->color->ColorName,
                'pack_quantity' => $maxmin->pack_quantity,
                'total_max' => $totalMax,
                'total_min' => $totalMin,
                'total_inventory' => $totalInventory,
                'branches' => $branchDetails,
                'stock_out_count' => $stockOutCount,
                'created_at' => $maxmin->created_at,
                'updated_at' => $maxmin->updated_at,
                'deleted_at' => $maxmin->deleted_at,
                'trashed' => $maxmin->trashed(),
            ]);

        });

        return collect($results);
    }
}
