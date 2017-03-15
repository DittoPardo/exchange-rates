<?php

/**
 * ExchangeRates
 *
 * @package ipaulk/exchange-rates
 * @link https://github.com/iPaulK/exchange-rates/
 * @license https://opensource.org/licenses/MIT
 */

namespace IPaulK\ExchangeRates;

class ExchangeRates
{
    /**
     * Current exchange provider
     *
     * @var IPaulK\ExchangeRates\ProviderInterface
     */
    protected $provider = null;

    public function __construct($provider = null)
    {
        $this->setProvider($provider);
    }

    /**
     * Returns provider
     * 
     * @return IPaulK\ExchangeRates\ProviderInterface
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param string
     * @return IPaulK\ExchangeRates\Rates
     */
    public function setProvider($provider = null)
    {
        $this->provider = ProviderFactory::factory($provider);
        return $this;
    }

    /**
     * Retrieve rate
     *
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return float
     */
    public function getRate($currencyFrom, $currencyTo)
    {
        return (float) $this->getProvider()->getRate($currencyFrom, $currencyTo);
    }

    /**
     * Retrieve rates
     *
     * @param string $baseCurrencyCode
     * @param array $currencyCodes
     * @return array
     */
    public function fetchRates($baseCurrencyCode, $currencyCodes)
    {
        return $this->getProvider()->fetchRates($baseCurrencyCode, $currencyCodes);
    }
}