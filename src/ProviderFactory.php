<?php

/**
 * ExchangeRates
 *
 * @package ipaulk/exchange-rates
 * @link https://github.com/iPaulK/exchange-rates/
 * @license https://opensource.org/licenses/MIT
 */

namespace IPaulK\ExchangeRates;

class ProviderFactory
{
    /**
     * Default provider
     *
     * @var string
     * @static
     */
    protected static $defaultProvider = 'webservicex';

    /**
     * Provider factory
     *
     * @param  string $provider
     * @return IPaulK\ExchangeRates\ProviderInterface
     */
    public static function factory($provider = null)
    {
        if ($provider === null) {
            $provider = static::$defaultProvider;
        }

        $providerClass = '\\IPaulK\\ExchangeRates\\Provider\\' . ucfirst(strtolower($provider));
        if (!class_exists($providerClass)) {
            throw new \Exception("Class ' . $providerClass . ' not found");
        }
        
        $provider = new $providerClass();
        if (!$provider instanceof ProviderInterface) {
            throw new \Exception("Provider must be an instance of IPaulK\ExchangeRates\Provider\ProviderInterface");
        }
        
        return $provider;
    }
}