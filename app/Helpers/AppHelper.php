<?php

if ( ! function_exists('amount_format')) {


    function amount_format($amount = 0, $currency = null): string
    {
        $currency = $currency ?? config('app.currency');

        return $currency.number_format($amount, 2);
    }
}
