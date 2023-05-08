<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\Currency;
use Illuminate\Support\Str;
use App\Repositories\CurrencyRepository;

class CurrencyService
{
    private object $client;
    private ?object $currency;
    private array $currencies;
    private array $data;
    private object $response;

    private object $currencyRepository;
    private object $apiIntegration;

    /**
     * @param CurrencyRepository $currencyRepository
     * @param ApiIntegration $apiIntegration
     */
    public function __construct(CurrencyRepository $currencyRepository, ApiIntegration $apiIntegration)
    {
        $this->currencyRepository = $currencyRepository;
        $this->apiIntegration = $apiIntegration;
    }

    /**
     * @return void
     */
    public function fetchCurrencyRates(): void
    {
        $this->data = $this->apiIntegration->makeApiCall();

        if (!empty($this->data) && is_array($this->data)) {
            $this->currencies = $this->data[0]['rates'];

            foreach ($this->currencies as $currencyData) {
                $this->updateCurrencyRate($currencyData);
            }
        }
    }

    /**
     * @param array $currencyData
     * 
     * @return void
     */
    private function updateCurrencyRate(array $currencyData): void
    {
        $this->currency = $this->currencyRepository->getByCurrencyCode($currencyData['code']);

        if ($this->currency) {
            $this->currencyRepository->update(
                $this->currency,
                ['exchange_rate' => $currencyData['mid']]
            );
        } else {
            $this->currencyRepository->create([
                'id' => Str::uuid(),
                'name' => $currencyData['currency'],
                'currency_code' => $currencyData['code'],
                'exchange_rate' => $currencyData['mid'],
            ]);
        }
    }
}
