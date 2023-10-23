<?php

namespace App\Services\Api\V1;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Spatie\OpeningHours\OpeningHours;

class TimeRangeService
{
    public static function generateDeliveryRange()
    {
        $openingHours = OpeningHours::create(BusinessHourService::getSlots());
        $ranges       = $openingHours->forDay(today()->dayName);
        $total_ranges = count($ranges);
        $start_time   = $total_ranges > 0 ? $ranges[0]->start()->hours().':'.$ranges[0]->start()->minutes() : '12:00';
        $end_time     = $total_ranges > 0 ? ($total_ranges > 1 ? $ranges[$total_ranges - 1]->end()->hours().':'.$ranges[$total_ranges - 1]->end()->minutes() : $ranges[0]->end()->hours().':'.$ranges[0]->end()->minutes()) : '00:00';

        //Validate Start Date
        if (Carbon::now()->greaterThan($start_time)) {
            $start_time = now()->format('H:i');
        }
        //
        $periods = CarbonPeriod::create($start_time, '1 hour', $end_time)->floorHour();

        $timeSlot = array_map(function ($date) {
            return $date->format('h:ia');
        }, $periods->toArray());

        $delivery_time = [];
        $timeSlotCount = count($timeSlot);
        for ($i = 0; $timeSlotCount > $i; $i++) {
            $nextIndex       = $i + 1;
            $delivery_time[] = 'today, '.$timeSlot[$i].' - '.$timeSlot[$nextIndex];
            if ($nextIndex === $timeSlotCount - 1) {
                break;
            }
        }

        return $delivery_time;
    }
}
