## Exchange Rates

Retrieve currency exchange rate using several web services.

## Available webservices:

1. WebserviceX.NET Data Protocol is a SOAP-inspired technology for reading, writing, and modifying information on the web.
2. Fixer.io is a free JSON API for current and historical foreign exchange rates published by the European Central Bank. 

## Installation

```
$ composer require ipaulk/exchange-rates
```

## Usage

Get specific exchange rate from Webservicex.net (by default)

```php
use IPaulK\ExchangeRates\ExchangeRates as ExchangeRates;

$rate = new ExchangeRates();

/** @var float $value */
$value = $rate->getRate('USD', 'EUR');
```

Get specific exchange rate from fixer.io

```php
use IPaulK\ExchangeRates\ExchangeRates as ExchangeRates;

$rate = new ExchangeRates('fixerio');

/** @var float $value */
$value = $rate->getRate('USD', 'EUR');
```

Request specific exchange rates.

```php
use IPaulK\ExchangeRates\ExchangeRates as ExchangeRates;

$rate = new ExchangeRates();

/** @var array $data */
$data = $rate->fetchRates('USD', ['EUR', 'GBP', 'JPY', 'RUB', 'ILS', 'AUD']);
```