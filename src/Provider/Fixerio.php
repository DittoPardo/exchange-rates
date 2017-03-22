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

class Fixerio implements ProviderInterface
{
    protected $url = 'http://api.fixer.io/latest?base={{BASE_CURRENCY}}&symbols={{CURRENCY_CODES}}';

    protected function conversion($baseCurrencyCode, $currencyCodes, $retry=0)
    {
        if (is_array($currencyCodes)) {
            $currencyCodes = implode(',', $currencyCodes);
        }

        $url = str_replace('{{BASE_CURRENCY}}', $baseCurrencyCode, $this->url);
        $url = str_replace('{{CURRENCY_CODES}}', $currencyCodes, $url);

        try {
            $client = new Client();
            $response = $client->request('GET', $url);

            if ($response->getStatusCode() === 200) {
                $body = $response->getBody();
                $data = json_decode($body, true);
                return $data;
            }
        } catch (\Exception $e) {
            if ($retry == 0) {
                $this->conversion($baseCurrencyCode, $currencyCodes, 1);
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
    public function getRate($baseCurrencyCode, $currencyTo)
    {
        $currencyCodes[] = $currencyTo;
        $data = $this->conversion($baseCurrencyCode, $currencyCodes);
        $rate = $data['rates'][$currencyTo];
        return (float) $rate;
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
        $data = $this->conversion($baseCurrencyCode, $currencyCodes);
        $result[$baseCurrencyCode] = $data['rates'];
        return $result;
    }
}