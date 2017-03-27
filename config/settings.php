<?php

return [
    'settings' => [
        'displayErrorDetails' => ('true' === getenv('DEBUG_DETAIL')), // set to false in production
        'debug' => ('true' === getenv('DEBUG_DETAIL')),
        'whoops.editor' => 'phpstorm',
        'middleware_config_dir' => APP_ROOT.'/config/middleware/',
        'route_config_dir' => APP_ROOT.'/config/routes/',
        'service_config_dir' => APP_ROOT.'/config/services/',
        'renderer' => [
            'template_path' => APP_ROOT.'/templates',
            'template_cache' => APP_ROOT.'/cache/'
        ],
        'logger' => [
            'name' => 'phlongtaiam-app',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/../logs/app.log',
        ]
    ]
];
