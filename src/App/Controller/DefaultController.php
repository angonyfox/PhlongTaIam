<?php
namespace App\Controller;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class DefaultController
{
    private $logger;
    private $view;

    public function __construct(LoggerInterface $logger, TWig $view)
    {
        $this->logger = $logger;
        $this->view = $view;
    }

    public function indexAction(RequestInterface $request, ResponseInterface $response, $args)
    {
        $this->logger->info("Skeleton '/' route");

        return $this->view->render($response, 'Default/index.html.twig', $args);
    }

    public function helloAction(RequestInterface $request, ResponseInterface $response, $args)
    {
        $name = $request->getAttribute('name');
        $response->getBody()->write("Hello, $name");
        $this->logger->addInfo("Hello happened");

        return $response;
    }

    public function throwException(RequestInterface $request, ResponseInterface $response, array $args)
    {
        $this->logger->info("Slim-Skeleton '/throw' route");

        throw new \Exception('testing errors 1.2.3..');
    }
}
