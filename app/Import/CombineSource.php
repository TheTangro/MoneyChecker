<?php

declare(strict_types=1);

namespace App\Import;

use App\Models\BalanceChange;

class CombineSource implements ImportSourceInterface
{
    /**
     * @param ImportSourceInterface[] $sources
     */
    public function __construct(
        private array $sources = []
    ) {
    }

    public function getItems(): iterable
    {
        foreach ($this->sources as $source) {
            yield from $source->getItems();
        }
    }
}
