<?php

declare(strict_types=1);

namespace App\Providers;

use App\Import\CombineSource;
use App\Import\DataExtractors\SmsXmlDumpDataExtractor;
use App\Import\FilePostProcessing\DeleteFileStrategy;
use App\Import\ImportSourceInterface;
use App\Import\Sources\FilesystemProvider;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Config;
use League\Flysystem\Filesystem;
use League\Flysystem\WebDAV\WebDAVAdapter;

class ImportSourceLocator extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(\App\Import\ImportSourceInterface::class, function($params) {
            return new CombineSource($this->resolveSources());
        });
    }

    /**
     * @return ImportSourceInterface[]
     */
    private function resolveSources(): array
    {
        $sources = [];
        $sources = array_merge($sources, $this->resolveWebdavSources());

        return $sources;
    }

    /**
     * @return ImportSourceInterface[]
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function resolveWebdavSources(): array
    {
        $sources = [];
        $userWebdavConfig = Config::get('webdav.user_configuration', []);
        $baseUri = Config::get('webdav.base_uri');

        foreach ($userWebdavConfig as $config) {
            $email = $config['email'] ?? '';
            $user = User::where('email', '=', $email)->get()->first();

            if ($user) {
                $dataExtractor = $this->app->get($config['data_extractor'] ?? SmsXmlDumpDataExtractor::class);
                $filePostProcessStrategy = $this->app->get($config['file_postprocessing'] ?? DeleteFileStrategy::class);
                $importDirectory = $config['import_directory'] ?? DIRECTORY_SEPARATOR;
                $nameRegex = $config['name_regex_pattern'] ?? FilesystemProvider::ACCEPT_ALL;
                $login = $config['login'] ?? '';
                $password = $config['password'] ?? '';
                $webdavClient = new \Sabre\DAV\Client([
                    'userName' => $login,
                    'password' => $password,
                    'baseUri' => $baseUri
                ]);
                $adapter = new WebDAVAdapter($webdavClient);
                $filesystem = new Filesystem($adapter);
                $sources[] = new FilesystemProvider(
                    $filesystem,
                    $dataExtractor,
                    $filePostProcessStrategy,
                    $importDirectory,
                    $nameRegex
                );
            }
        }

        return $sources;
    }

    public function provides(): array
    {
        return [ImportSourceInterface::class];
    }
}
