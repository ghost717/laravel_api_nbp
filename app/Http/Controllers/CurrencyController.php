<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    private object $currencyService;

    /**
     * @param CurrencyService $currencyService
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function syncCurrencies()
    {
        $this->currencyService->fetchCurrencyRates();

        return response()->json(['message' => 'Currencies synchronized successfully']);
    }
}