<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property Carbon changeTime
 * @property double $baseDelta
 * @property Currency $baseCurrency
 * @property int $baseCurrencyId
 * @property double $nationalDelta
 * @property Currency $nationalCurrency
 * @property int $nationalCurrencyId
 * @property int $userId
 * @property User $user
 * @property string $type
 * @property int $receiverId
 * @property Receiver $receiver
 * @property int $sourceId
 * @property Source $source
 * @property Carbon $createdAt
 */
class BalanceChange extends Model
{
    use HasFactory;

    public const CREATED_AT = 'created_at';
    public const CHANGE_TIME = 'change_time';
    public const BASE_CURRENCY_ID = 'base_currency_id';
    public const NATIONAL_CURRENCY_ID = 'national_currency_id';
    public const RECEIVER_ID = 'receiver_id';
    public const SOURCE_ID = 'source_id';

    protected $dates = [
        self::CREATED_AT,
        self::CHANGE_TIME
    ];

    public $timestamps = false;

    public function baseCurrency(): HasOne
    {
        return $this->hasOne(Currency::class, self::BASE_CURRENCY_ID);
    }

    public function nationalCurrency(): HasOne
    {
        return $this->hasOne(Currency::class, self::NATIONAL_CURRENCY_ID);
    }

    public function receiver(): HasOne
    {
        return $this->hasOne(Receiver::class, self::RECEIVER_ID);
    }

    public function source(): HasOne
    {
        return $this->hasOne(Source::class, self::SOURCE_ID);
    }
}
