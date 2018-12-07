<?php
/**
 * Created by PhpStorm.
 * User: waled
 * Date: 04/04/2018
 * Time: 15:15
 */

namespace TSI\Auth\Infrastructure\HttpClient\Guzzle;


use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TSI\Auth\Infrastructure\HttpClient\HttpClientInterface;

class GuzzleClient implements HttpClientInterface
{
    /**
     * @var ClientInterface
     */
    private $guzzleClient;

    /**
     * GuzzleClient constructor.
     * @param ClientInterface $guzzleClient
     */
    public function __construct(ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }


    public function send(RequestInterface $request): ResponseInterface
    {
        return $this->guzzleClient->send($request);
    }

}