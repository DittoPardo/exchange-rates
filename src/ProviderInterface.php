<?php

/**
 * ExchangeRates
 *
 * @package ipaulk/exchange-rates
 * @link https://github.com/iPaulK/exchange-rates/
 * @license https://opensource.org/licenses/MIT
 */

namespace IPaulK\ExchangeRates;

interface ProviderInterface
{
    /**
     * Retrieve rate
     *
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return float
     */
    public function getRate($currencyFrom, $currencyTo);

    /**
     * Retrieve rates
     *
     * @param string $baseCurrencyCode
     * @param array $currencyCodes
     * @return array
     */
    public function fetchRates($baseCurrencyCode, $currencyCodes);
}