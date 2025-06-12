<?php
namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function getDefaultDateRanges()
    {
        $dates = [];

        // Hoy
        $dates['today'] = Carbon::today()->format('Y-m-d');
        $dates['todaySameWeekdayLastYear'] = Carbon::today()->subYear()
            ->next(Carbon::today()->format('l'))
            ->format('Y-m-d');
        //Ayer
        $dates['yesterday'] = Carbon::today()->subDay()->format('Y-m-d');
        $dates['sameWeekdayLastYear'] = Carbon::today()->subDay()->subYear()
            ->next(Carbon::today()->subDay()->format('l'))
            ->format('Y-m-d');
        /// Mes Actual
        $dates['thisMonthInitial'] = Carbon::today()->startOfMonth()->format('Y-m-d');
        $dates['yesterday'] = Carbon::today()->subDay()->format('Y-m-d');
        $dates['thisMonthInitialLastYear'] = Carbon::today()->subYear()->startOfMonth()->format('Y-m-d');
        $dates['yesterdayLastYear'] = Carbon::today()->subDay()->subYear()->format('Y-m-d');
        // Mes Pasado
        $dates['lastMonthInitial'] = Carbon::today()->subMonth()->startOfMonth()->format('Y-m-d');
        $dates['lastMonthEnd'] = Carbon::today()->subMonth()->endOfMonth()->format('Y-m-d');
        $dates['lastMonthInitialLastYear'] = Carbon::today()->subYear()->subMonth()->startOfMonth()->format('Y-m-d');
        $dates['lastMonthEndLastYear'] = Carbon::today()->subYear()->subMonth()->endOfMonth()->format('Y-m-d');
        // Semana
        $day = Carbon::yesterday();
        $initialWeekdayLastYear = $day->copy()->addDays(2)->subYear()->startOfWeek(Carbon::MONDAY);
        $dayDifference = $day->copy()->getDaysFromStartOfWeek(1);
        $dates['initialWeekday'] = $day->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $dates['initialWeekdayLastYear'] = $initialWeekdayLastYear->format('Y-m-d');
        $dates['finalWeekdayLastYear'] = $initialWeekdayLastYear->copy()->addDays($dayDifference)->format('Y-m-d');
        //Ultmimos 7 dias
        $dates['initialSevenDays'] = $day->copy()->subDays(6)->format('Y-m-d');
        $dates['finalSevenDays'] = $day->format('Y-m-d');
        $dates['initialSevenDaysLastYear'] = $day->copy()->subDays(5)->subYear()->format('Y-m-d');
        $dates['finalSevenDaysLastYear'] = $day->copy()->addDays(1)->subYear()->format('Y-m-d');
        // Ultimas dos semanas
        $dates['initialTwoWeeks'] = $day->copy()->yesterday()->subDays(13)->format('Y-m-d');
        $dates['initialTwoWeeksLastYear'] = $day->copy()->yesterday()->subYear()->subDays(12)->format('Y-m-d');
        $dates['finalTwoWeeksLastYear'] = $day->copy()->yesterday()->subYear()->addDays(1)->format('Y-m-d');

        // Mes Actual
        $dates['initialMonth'] = $day->copy()->startOfMonth()->format('Y-m-d');
        $dates['finalMonth'] = $day->copy()->endOfMonth()->format('Y-m-d');
        $dates['initialMonthLastYear'] = $day->copy()->subYear()->startOfMonth()->format('Y-m-d');
        $dates['finalMonthLastYear'] = $day->copy()->subYear()->endOfMonth()->format('Y-m-d');

        // Whole Year
        $yesterday = Carbon::yesterday();
        $dates['initialYear'] = $yesterday->copy()->firstOfYear()->format('Y-m-d');
        $dates['initialLastYear'] = $yesterday->copy()->subYear()->firstOfYear()->format('Y-m-d');
        $dates['finalLastYear'] = $yesterday->copy()->subYear()->format('Y-m-d');

        // Invierno this year

        $dates['initialWinter'] = Carbon::now()->month(9)->day(1)->format('Y-m-d');
        $isWinter = Carbon::today()->isAfter($dates['initialWinter']);
        $dates['initialWinterLastYear'] = Carbon::now()->startOfYear()->subYear()->month(9)->day(1)->format('Y-m-d');
        $dates['finalWinter'] = $isWinter ? $dates['yesterday'] : Carbon::now()->startOfYear()->month(12)->day(31)->format('Y-m-d');
        $dates['finalWinterLastYear'] = $isWinter ? $dates['yesterdayLastYear'] : Carbon::now()->startOfYear()->subYear()->month(12)->day(31)->format('Y-m-d');

        //Verano
        $dates['finalSummer'] = $isWinter ? Carbon::now()->startOfYear()->month(8)->day(31)->format('Y-m-d') : $day;
        $dates['finalSummerLastYear'] = $isWinter ? Carbon::now()->startOfYear()->subYear()->month(8)->day(31)->format('Y-m-d') : $dates['yesterday'];

        return $dates;
    }

    public static function parseDateRange(string $input)
    {
        $dates = array_map('trim', explode('to', $input));

        if (count($dates) === 1) {
            $dates[] = $dates[0]; // mismo inicio y fin
        }

        return [
            Carbon::createFromFormat('Y-m-d', $dates[0])->setTime(0, 0, 0),
            Carbon::createFromFormat('Y-m-d', $dates[1])->setTime(0, 0, 0),
        ];
    }
}
