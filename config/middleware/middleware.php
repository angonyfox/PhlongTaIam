<?php
$container = $app->getContainer();

if ($container->get("settings")["displayErrorDetails"]) {
    $app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);
};
