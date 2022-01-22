<?php

declare(strict_types=1);

namespace App\Import\Sources;

use App\Exceptions\Import\ImportDirectoryDoesNotExistsException;
use App\Import\DataExtractors\FileDataExtractorInterface;
use App\Import\FilePostProcessing\PostProcessFileStrategyInterface;
use App\Import\ImportSourceInterface;
use League\Flysystem\FilesystemInterface;

class FilesystemProvider implements ImportSourceInterface
{
    public const ACCEPT_ALL = '/^.+$/';

    private FilesystemInterface $filesystem;

    private FileDataExtractorInterface $fileDataExtractor;

    private string $directoryPath;

    private string $nameRegexPattern;

    private PostProcessFileStrategyInterface $postProcessFileStrategy;

    public function __construct(
        FilesystemInterface $filesystem,
        FileDataExtractorInterface $fileDataExtractor,
        PostProcessFileStrategyInterface $postProcessFileStrategy,
        string $directoryPath,
        string $nameRegexPattern = self::ACCEPT_ALL
    ) {
        $this->filesystem = $filesystem;
        $this->fileDataExtractor = $fileDataExtractor;
        $this->directoryPath = $directoryPath;
        $this->nameRegexPattern = $nameRegexPattern;
        $this->postProcessFileStrategy = $postProcessFileStrategy;
    }

    public function getItems(): iterable
    {
        if (!$this->filesystem->has($this->directoryPath)) {
            throw new ImportDirectoryDoesNotExistsException(
                __('Provided directory is invalid or  does not exists')
            );
        }

        $filesList = $this->filesystem->listContents($this->directoryPath);

        foreach ($filesList as $fileData) {
            $name = $fileData['filename'] ?? '';
            $file = $fileData['path'];

            if (preg_match($this->nameRegexPattern, $name)
                && in_array($this->filesystem->getMimetype($file), $this->fileDataExtractor->getAcceptableMimeTypes())
            ) {
                $fileExtractor = $this->fileDataExtractor->setFile($this->filesystem->readStream($file));

                yield from $fileExtractor->getData();

                $this->postProcessFileStrategy->process($file, $this->filesystem);
            }
        }
    }
}
