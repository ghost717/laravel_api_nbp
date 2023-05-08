<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Currency;
use Illuminate\Support\Str;
use App\Repositories\CurrencyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;
    
    public function testCreateCurrency()
    {
        $currencyData = [
            'id' => Str::uuid(),
            'name' => 'Euro',
            'currency_code' => 'EUR',
            'exchange_rate' => 4.75,
        ];

        $currency = Currency::create($currencyData);

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertDatabaseHas('currencies', $currencyData);
    }

    public function testUpdateCurrency()
    {
        $currency = Currency::create([
            'id' => Str::uuid(),
            'name' => 'US Dollar',
            'currency_code' => 'USD',
            'exchange_rate' => 3.75,
        ]);

        $currency->update([
            'exchange_rate' => 3.80,
        ]);

        $this->assertEquals(3.80, $currency->exchange_rate);
    }

    public function testGetCurrency()
    {   
        $uuid = Str::uuid();
        Currency::create([
            'id' => $uuid,
            'name' => 'US Dollar',
            'currency_code' => 'USD',
            'exchange_rate' => 3.75,
        ]);

        $currency = Currency::find($uuid);

        $this->assertEquals('US Dollar', $currency->name);
        $this->assertEquals('USD', $currency->currency_code);
        $this->assertEquals(3.75, $currency->exchange_rate);
    }

    public function testDeleteCurrency()
    {
        $uuid = Str::uuid();
        Currency::create([
            'id' => $uuid,
            'name' => 'US Dollar',
            'currency_code' => 'USD',
            'exchange_rate' => 3.75,
        ]);

        $currency = Currency::find($uuid);
        $currency->delete();

        $this->assertDatabaseMissing('currencies', [
            'id' => $uuid,
        ]);
    }

    public function testGetCurrencyByCurrencyCode()
    {
        $currencyData = [
            'id' => Str::uuid(),
            'name' => 'Euro',
            'currency_code' => 'EUR',
            'exchange_rate' => 4.75,
        ];

        $currencyRepository = new CurrencyRepository();
        $currencyRepository->create($currencyData);
        $currency = $currencyRepository->getByCurrencyCode('EUR');

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertEquals('Euro', $currency->name);
    }
}
