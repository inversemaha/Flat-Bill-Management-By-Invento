<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Format amount with BDT currency symbol
     *
     * @param float $amount
     * @param int $decimals
     * @return string
     */
    public static function format(float $amount, int $decimals = 2): string
    {
        return '৳' . number_format($amount, $decimals);
    }

    /**
     * Get currency symbol
     *
     * @return string
     */
    public static function symbol(): string
    {
        return '৳';
    }

    /**
     * Get currency code
     *
     * @return string
     */
    public static function code(): string
    {
        return 'BDT';
    }

    /**
     * Get currency name
     *
     * @return string
     */
    public static function name(): string
    {
        return 'Bangladeshi Taka';
    }
}
