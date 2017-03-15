## Exchange Rates
Retrieve currency exchange rate using several web services.

## Usage

```php
use IPaulK\ExchangeRates\ExchangeRates as ExchangeRates;

$rate = new ExchangeRates();

/** @var float $value */
$value = $rate->getRate('USD', 'EUR');
```

```php
use IPaulK\ExchangeRates\ExchangeRates as ExchangeRates;

$rate = new ExchangeRates();

/** @var array $value */
$data = $rate->fetchRates('USD', array('EUR', 'GBP', 'JPY', 'RUB', 'ILS', 'AUD'));
```