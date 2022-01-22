<?php

declare(strict_types=1);

namespace App\Import\FilePostProcessing;

use League\Flysystem\FilesystemInterface;

interface PostProcessFileStrategyInterface
{
    public function process(string $filePath, FilesystemInterface $filesystem): void;
}
