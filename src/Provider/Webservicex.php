<?php

/**
 * ExchangeRates
 *
 * @package ipaulk/exchange-rates
 * @link https://github.com/iPaulK/exchange-rates/
 * @license https://opensource.org/licenses/MIT
 */

namespace IPaulK\ExchangeRates\Provider;

use IPaulK\ExchangeRates\ProviderInterface;
use GuzzleHttp\Client;

class Webservicex implements ProviderInterface
{
    protected $url = 'http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency={{CURRENCY_FROM}}&ToCurrency={{CURRENCY_TO}}';

    protected function conversion($currencyFrom, $currencyTo, $retry=0)
    {
        $url = str_replace('{{CURRENCY_FROM}}', $currencyFrom, $this->url);
        $url = str_replace('{{CURRENCY_TO}}', $currencyTo, $url);

        try {
            $client = new Client();
            $response = $client->request('GET', $url);

            if ($response->getStatusCode() === 200) {
                $body = $response->getBody();
                $xml = $body->getContents();
                $res = simplexml_load_string($xml, null, LIBXML_NOERROR);
                
                return (float) $res;
            }
        } catch (\Exception $e) {
            if ($retry == 0) {
                $this->conversion($currencyFrom, $currencyTo, 1);
            }
        }

        return null;
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
        return (float) $this->conversion($currencyFrom, $currencyTo);
    }

    /**
     * Retrieve rates
     *
     * @param string $baseCurrencyCode
     * @param [] $currencyCodes
     * @return []
     */
    public function fetchRates($baseCurrencyCode, $currencyCodes)
    {
        $data = [];

        @set_time_limit(0);
        foreach ($currencyCodes as $currencyTo) {
            if ($baseCurrencyCode == $currencyTo) {
                $data[$baseCurrencyCode][$currencyTo] = 1;
            } else {
                $data[$baseCurrencyCode][$currencyTo] = $this->conversion($baseCurrencyCode, $currencyTo);
            }
        }

        return $data;
    }
}