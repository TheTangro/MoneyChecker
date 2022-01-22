<?php

declare(strict_types=1);

namespace App\Import\DataExtractors;

/**
 * @immutable
 */
interface FileDataExtractorInterface extends DataExtractorInterface
{
    /**
     * Returns new instance of extractor
     *
     * @param $file
     * @return FileDataExtractorInterface
     */
    public function setFile($file): FileDataExtractorInterface;

    public function getAcceptableMimeTypes(): array;
}
