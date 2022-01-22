<?php

declare(strict_types=1);

namespace App\Import;

use App\Models\BalanceChange;

interface ImportSourceInterface
{
    /**
     * @return BalanceChange[]
     */
    public function getItems(): iterable;
}
