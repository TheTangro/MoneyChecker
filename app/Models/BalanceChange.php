<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BalanceChange extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function baseCurrency(): HasOne
    {
        return $this->hasOne(Currency::class, 'base_currency_id');
    }

    public function nationalCurrency(): HasOne
    {
        return $this->hasOne(Currency::class, 'national_currency_id');
    }
}
