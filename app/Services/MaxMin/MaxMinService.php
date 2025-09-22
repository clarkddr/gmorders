<?php
namespace App\Services\MaxMin;

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
}
