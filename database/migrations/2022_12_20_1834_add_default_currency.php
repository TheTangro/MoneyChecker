<?php

use App\Models\Currency;
use Illuminate\Database\Migrations\Migration;

class AddDefaultCurrency extends Migration
{
    public function up()
    {
        $currency = $this->getDefaultCurrency();

        if (!$currency) {
            $currency = new Currency;

            $currency->code = Currency::DEFAULT_CURRENCY_CODE;
            $currency->save();
        }
    }

    public function down(): void
    {
        $currency = $this->getDefaultCurrency();

        if ($currency) {
            $currency->delete();
        }
    }

    private function getDefaultCurrency(): ?Currency
    {
        try {
            /** @var Currency $currency **/
            $currency = Currency::where('code', '=', Currency::DEFAULT_CURRENCY_CODE)->first();

            return $currency;
        } catch (Throwable $e) {
            return null;
        }
    }
}
