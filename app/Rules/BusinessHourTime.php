<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BusinessHourTime implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //Validate Single Time slot
        $timeslots = array_map(function ($item) use ($fail) {
            $explode = explode('-', $item);
            if (count($explode) !== 2) {
                $fail('Invalid time slots.');
            }

            if (count($explode) === 2 && $explode[0] >= $explode[1]) {
                $fail('Invalid time slots.');
            }

            return $explode;
        }, $value);


        $total_slots = count($timeslots);
        for ($i = 1; $i < $total_slots; $i++) {
            if ((isset($timeslots[$i - 1][1]) && $timeslots[$i][0]) && $timeslots[$i - 1][1] >= $timeslots[$i][0]) {
                $fail('Invalid time slots.');
            }
        }
    }
}
