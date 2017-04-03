<?php
namespace App\Controller;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhlongTaIam\WordBreaker as WordBreaker;

class ApiController
{
    private $logger;
    private $wordbreaker;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->wordbreaker = new WordBreaker(APP_ROOT . "/data/tdict-std.txt");
    }

    public function breakIntoWordsAction(RequestInterface $request, ResponseInterface $response, $args)
    {
        $text = $request->getAttribute('text');
        $data = array();
        if (!empty($text))
        {
            $this->logger->addInfo("Input:".$text);
            $outputarr = $this->wordbreaker->breakIntoWords($text);
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

    public function breakIntoWordsFileAction(RequestInterface $request, ResponseInterface $response, $args)
    {

        $this->logger->addInfo("File:".$_FILES['file_data']['name']);
        $this->logger->addInfo("TempFile:".$_FILES['file_data']['tmp_name']);
        $fhandler = fopen($_FILES['file_data']['tmp_name'], 'r');
        $outputfile = fopen(APP_ROOT."/public/output/output.csv","w");
        while (($data = fgetcsv($fhandler)) !== FALSE )
        {
            $splittextarr = $this->wordbreaker->breakIntoWords($data[0]);
            $splittextarr = array_map('trim', $splittextarr);
            $splittextarr = array_filter($splittextarr);
            $splittext = implode("|",$splittextarr);

            $outputdata = $data;
            $outputdata[] = $splittext;
            $this->logger->addInfo("Data:".$data[0]);
            $this->logger->addInfo("BreakText:".$splittext);
            fputcsv($outputfile, $outputdata);
        }
        fclose($fhandler);
        fclose($outputfile);
        $data = array();
        return $response->withJson((object)$data);
    }

    public function downloadAction(RequestInterface $request, ResponseInterface $response, $args)
    {
        $file = APP_ROOT."/public/output/output.csv";
        $fh = fopen($file, 'rb');

        $stream = new \Slim\Http\Stream($fh); // create a stream instance for the response body

        return $response->withHeader('Content-Type', 'application/force-download')
                        ->withHeader('Content-Type', 'application/octet-stream')
                        ->withHeader('Content-Type', 'application/download')
                        ->withHeader('Content-Description', 'File Transfer')
                        ->withHeader('Content-Transfer-Encoding', 'binary')
                        ->withHeader('Content-Disposition', 'attachment; filename="' . basename($file) . '"')
                        ->withHeader('Expires', '0')
                        ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                        ->withHeader('Pragma', 'public')
                        ->withBody($stream); // all stream contents will be sent to the response
    }
}
