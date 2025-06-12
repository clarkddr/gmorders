<?php
namespace App\Transformers\SalesByYearReports;
use Illuminate\Support\Collection;

class WeeklyChartTransformer {
    public function transform(Collection $weeklySales) {
        $labels = [];
        $salesByYear = [];
        $discountsByYear = [];

        foreach ($weeklySales as $row) {
            $range = "{$row->InitialDate} - {$row->EndDate}";
            $year = $row->Year;

            if (!in_array($range, $labels)) {
                $labels[] = $range;
            }

            $salesByYear[$year][$range] = (float) $row->Sale;
            $discountsByYear[$year][$range] = (float) $row->Discount;
        }

        $datasets = [];

        foreach ($salesByYear as $year => $sales) {
            $datasets[] = [
                'label' => "{$year} - Ventas",
                'data' => array_map(fn($label) => $sales[$label] ?? null, $labels),
                'borderWidth' => 2,
                'pointRadius' => 0,
            ];

            $discounts = $discountsByYear[$year] ?? [];
            $datasets[] = [
                'label' => "{$year} - Descuentos",
                'data' => array_map(fn($label) => $discounts[$label] ?? null, $labels),
                'borderWidth' => 1,
                'borderDash' => [5, 5],
                'pointRadius' => 0,
                'hidden' => true
            ];
        }
        $datasets = collect($datasets)->sortBy('label')->values()->all();
        // hacer que siempre vaya venta antes que descuento en los legends
        usort($datasets, function ($a, $b) {
            [$yearA, $typeA] = explode(' - ', $a['label']);
            [$yearB, $typeB] = explode(' - ', $b['label']);
            return $yearA <=> $yearB ?: ($typeA === 'Venta' ? -1 : 1);
        });

        // Obtenemos los años mas recientes para ponerlos como default en grafico
        $allYears = collect($datasets)
            ->map(fn($d) => explode(' - ', $d['label'])[0])
            ->unique()->sortDesc()->take(2)
            ->values()->all();
        // Se recorren los datasets para encontrar y marcar como hidden los que no son los ultimos dos para
        $datasets = collect($datasets)->map(function($dataset) use($allYears){
            [$year] = explode(' - ', $dataset['label']);
            if(!in_array($year, $allYears)){
                $dataset['hidden'] = true;
            }
            return $dataset;
        })->values()->all();

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }
}
