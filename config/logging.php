<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;

return [

    'channels' => [
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel-'.posix_getpwuid(posix_geteuid())['name'].'.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
            'replace_placeholders' => true,
        ],

        'bugsnag' => [
            'driver' => 'bugsnag',
        ],
    ],

];
