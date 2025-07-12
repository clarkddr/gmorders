<?php
namespace App\Services\Performance;

use App\Repositories\Performance\PerformanceRepository;
use Carbon\Carbon;
use App\Models\Family;
use App\Models\Branch;
use App\Models\Category;
class PerformanceService {
    protected PerformanceRepository $repository;

    public function __construct(PerformanceRepository $repository) {
        $this->repository = $repository;
    }

    public function getData(string $saleFrom, string $saleTo,
                            string $purchaseFrom, string $purchaseTo,
                            int $branchid = 0, int $familyid = 0, int $categoryid = 0, int $supplierid = 0) {
        // Llamamos al repositorio y pasamos los parámetros de fecha como String
        $rawReport = $this->repository->getPerformanceData(
            Carbon::parse($saleFrom), Carbon::parse($saleTo),
            Carbon::parse($purchaseFrom), Carbon::parse($purchaseTo),
            $branchid, $familyid, $categoryid, $supplierid
        );
        // Se recolecta la informacion para complementarlo a los datos
        $categories = Category::pluck('Name','CategoryId');
        $branches = Branch::pluck('Name','BranchId');
        $families = Family::pluck('Name','FamilyId');


        // Se realizan las iteraciones para agregar datos a los arreglos
//        $byCategory = $rawReport['byCategory']->map(function($item)use($categories){
//            $item->CategoryName = $categories[$item->CategoryId];
//            return $item;
//        });



//        $byFamily = $rawReport['salesDiscountsByFamily']->map(function($item)use($families){
//            $item->FamilyName = $families[$item->FamilyId];
//            return $item;
//        });
//
//        $byBranch = $rawReport['salesDiscountsByBranch']->map(function($item)use($branches){
//            $item->BranchName = $branches[$item->BranchId];
//            return $item;
//        });

        // Se retorna toda la informacion
        return collect([
            'byCategory' => collect($rawReport['byCategory']),
            'byFamily' => collect($rawReport['byFamily']),
            'byBranch' => collect($rawReport['byBranch']),
            'bySupplier' => collect($rawReport['bySupplier']),
            'results' => collect($rawReport['results']),
        ]);

    }
}
