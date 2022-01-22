<?php

use App\Import\DataExtractors\SmsXmlDumpDataExtractor;
use App\Import\FilePostProcessing\DeleteFileStrategy;
use App\Import\Sources\FilesystemProvider;

return [
    'user_configuration' => [
        [
            'email' => env('TT_WEBDAV_EMAIL', ''),
            'login' => env('TT_WEBDAV_LOGIN', ''),
            'password' => env('TT_WEBDAV_PASSWORD', ''),
            'data_extractor' => SmsXmlDumpDataExtractor::class,
            'file_postprocessing' => DeleteFileStrategy::class,
            'name_regex_pattern' => FilesystemProvider::ACCEPT_ALL,
            'import_directory' => '/money_import'
        ]
    ],
    'base_uri' => 'https://webdav.yandex.ru'
];
