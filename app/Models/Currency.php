<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    const DEFAULT_CURRENCY_CODE = 'BYN';

    const TABLE_NAME = 'currency';

    public $timestamps = false;

    use HasFactory;

    protected $table = self::TABLE_NAME;
}
