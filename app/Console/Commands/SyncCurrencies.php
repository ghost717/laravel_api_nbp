<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CurrencyService;

class SyncCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync currencies from NBP API';

    private object $currencyService;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->currencyService = app(CurrencyService::class);
        $this->currencyService->fetchCurrencyRates();
    
        $this->info('Currencies synchronized successfully.');
    }
}
