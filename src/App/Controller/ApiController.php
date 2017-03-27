<?php
namespace App\Controller;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhlongTaIam\WordBreaker as WordBreaker;

class ApiController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function breakIntoWordsAction(RequestInterface $request, ResponseInterface $response, $args)
    {
        $text = $request->getAttribute('text');
        $data = array();
        if (!empty($text))
        {
            $this->logger->addInfo("Input:".$text);
            $wordBreaker = new WordBreaker(APP_ROOT . "/data/tdict-std.txt");
            $outputarr = $wordBreaker->breakIntoWords($text);
            if (count($outputarr))
            {
                $output = implode("|", $outputarr);
                $data['output'] = $output;
            }
            else
            {
                $data['output'] = $text;
            }
        }
        else
        {
            $this->logger->addInfo("Empty Input");
            $data['error'] = "Input text must not empty";
        }
        $response = $response->withHeader('Content-Type','application/json');
        if (array_key_exists('error', $data))
        {
            return $response->withJson($data, 500);
        }
        else
        {
            return $response->withJson($data);
        }
    }
}
