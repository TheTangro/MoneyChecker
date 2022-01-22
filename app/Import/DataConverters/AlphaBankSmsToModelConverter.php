<?php

declare(strict_types=1);

namespace App\Import\DataConverters;

use App\Models\BalanceChange;

class AlphaBankSmsToModelConverter
{
    public function convert(string $smsText): BalanceChange
    {

    }
}
