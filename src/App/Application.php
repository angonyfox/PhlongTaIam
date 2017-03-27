<?php
namespace App;

use Slim\App;
use App\Loader\MiddlewareLoader;
use App\Loader\RouteLoader;
use App\Loader\ServiceLoader;

/**
 * {@inheritDoc}
 */
class Application extends App
{
    private $dir = null;

    public function __construct($container = [])
    {
        parent::__construct($container);
        $this->loadMiddleware();
        $this->loadRoutes();
        $this->loadServices();
    }

    /**
     * Get root directory.
     * @return string
     * @throws ConstantNotSetException
     */
    public function getRootDir()
    {
        if(!defined('APP_ROOT')){
            throw new ConstantNotSetException('Application root not defined.');
        }

        return APP_ROOT;
    }

    private function loadMiddleware()
    {
        $loader = new MiddlewareLoader();
        $loader->loadMiddleware($this);
    }

    private function loadRoutes()
    {
        $loader = new RouteLoader();
        $loader->loadRoutes($this);
    }

    private function loadServices()
    {
        $loader = new ServiceLoader();
        $loader->loadServices($this);
    }
}
