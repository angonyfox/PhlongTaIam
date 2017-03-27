<?php
$container = $app->getContainer();

$container['DefaultController'] = function($container)
{
    return new \App\Controller\DefaultController(
        $container->get('logger'),
        $container->get('view')
    );
};

$container['ApiController'] = function($container)
{
    return new \App\Controller\ApiController(
        $container->get('logger')
    );
};
