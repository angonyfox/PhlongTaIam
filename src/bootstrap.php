<?php
// Set the project's base
if (!defined('APP_ROOT')) {
    $spl = new SplFileInfo(__DIR__ . '/..');
    define('APP_ROOT', $spl->getRealPath());
}

$loader = require_once APP_ROOT.'/vendor/autoload.php';

// Load Environment file
$dotEnv = new \Dotenv\Dotenv(APP_ROOT.'/config/env','environment.env');
$dotEnv->load();

$settings = require APP_ROOT.'/config/settings.php';

return new App\Application($settings);
