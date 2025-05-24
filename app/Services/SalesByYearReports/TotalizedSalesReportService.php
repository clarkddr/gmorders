<?php
namespace App\Services\SalesByYearReports;

use App\Repositories\SalesByYearReports\TotalizedSalesReportRepository;
use Carbon\Carbon;
use App\Models\Family;
use App\Models\Branch;
class TotalizedSalesReportService {
    protected TotalizedSalesReportRepository $repository;

    public function __construct(TotalizedSalesReportRepository $repository) {
        $this->repository = $repository;
    }

    public function getData(string $from, string $to, int $branchid = 0, int $familyid = 0) {
        // Llamamos al repositorio y pasamos los parámetros de fecha como String
        $rawReport = $this->repository->getYearSalesDiscounts(
            Carbon::parse($from),
            Carbon::parse($to),
            $branchid, $familyid
        );
        // Se recolecta la informacion para complementarlo a los datos
        $branches = Branch::pluck('Name','BranchId');
        $families = Family::pluck('Name','FamilyId');

        // Se realizan las iteraciones para agregar datos a los arreglos
        $byFamily = $rawReport['salesDiscountsByFamily']->map(function($item)use($families){
            $item->FamilyName = $families[$item->FamilyId];
            return $item;
        });

        $byBranch = $rawReport['salesDiscountsByBranch']->map(function($item)use($branches){
           $item->BranchName = $branches[$item->BranchId];
           return $item;
        });

        // Se retorna toda la informacion
        return [
            'weeks' => $rawReport['weeklySales'],
            'byFamily' => $byFamily,
            'byBranch' => $byBranch
        ];



    }
}
