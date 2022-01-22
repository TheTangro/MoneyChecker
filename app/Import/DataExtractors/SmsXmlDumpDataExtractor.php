<?php

declare(strict_types=1);

namespace App\Import\DataExtractors;

use App\Exceptions\Import\InvalidImportSourceException;
use App\Import\DataConverters\AlphaBankSmsToModelConverter;
use App\Import\DataFilters\AlphaBankSmsFilter;
use App\Models\BalanceChange;
use SimpleXMLElement;

class SmsXmlDumpDataExtractor implements FileDataExtractorInterface
{
    /**
     * @var null|resource|string
     */
    private $file = null;

    public function __construct(
        private AlphaBankSmsToModelConverter $smsConverter,
        private AlphaBankSmsFilter $alphaBankSmsFilter
    )
    {
    }

    public function getData(): iterable
    {
        if ($this->file === null) {
            yield from [];
        }

        if (is_resource($this->file)) {
            yield from $this->parseData($this->file);
        }

        if (is_string($this->file)) {
            try {
                $resource = fopen($this->file, 'r+');

                if (!$resource) {
                    throw new InvalidImportSourceException(__('Import source must be an readable file'));
                }

                yield from $this->parseData($resource);
            } finally {
                if (is_resource($resource)) {
                    fclose($resource);
                }
            }
        }
    }

    /**
     * @param $fileResource
     * @return BalanceChange[]
     */
    private function parseData($fileResource): iterable
    {
        $smsTexts = [];

        $parser = xml_parser_create();
        xml_set_element_handler(
            $parser,
            function ($parser, $name, $attrs) use (&$smsTexts) {
                $smsText = $attrs['BODY'] ?? '';

                if ($name === 'SMS' && $this->alphaBankSmsFilter->isAcceptable($smsText)) {
                    $smsTexts[] = $smsText;
                }
            },
            function () {
            }
        );

        while ($data = fread($this->file, 4096)) {
            xml_parse($parser, $data);
        }

        xml_parser_free($parser);

        return array_map([$this->smsConverter, 'convert'], $smsTexts);
    }

    public function setFile($file): SmsXmlDumpDataExtractor
    {
        $currentFile = $this->file;
        $this->file = $file;
        $newInstance = clone $this;
        $this->file = $currentFile;

        return $newInstance;
    }

    public function getAcceptableMimeTypes(): array
    {
        return [
            'text/xml'
        ];
    }
}
