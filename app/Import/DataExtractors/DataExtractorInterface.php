<?php

declare(strict_types=1);

namespace App\Import\DataExtractors;

use App\Exceptions\Import\NoSourceProvidedException;
use App\Models\BalanceChange;

interface DataExtractorInterface
{
    /**
     * @return BalanceChange[]
     *
     * @throws NoSourceProvidedException
     */
    public function getData(): iterable;
}
