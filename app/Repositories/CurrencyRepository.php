<?php

namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository
{
    private object $currency;

    /**
     * @param string $currencyCode
     * 
     * @return Currency
     */
    public function getByCurrencyCode(string $currencyCode): ?Currency
    {
        return Currency::where('currency_code', $currencyCode)->first();
    }

    /**
     * @param array $data
     * 
     * @return Currency
     */
    public function create(array $data): Currency
    {
        return Currency::create($data);
    }

    /**
     * @param Currency $currency
     * @param array $data
     * 
     * @return Currency
     */
    public function update(Currency $currency, array $data): Currency
    {
        $this->currency = $currency;
        $this->currency->update($data);
        return $this->currency;
    }
}
