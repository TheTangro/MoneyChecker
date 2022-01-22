<?php

declare(strict_types=1);

namespace App\Import\DataFilters;

class AlphaBankSmsFilter
{
    public function isAcceptable(string $smsText): bool
    {
        return true;
    }
}
