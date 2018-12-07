<?php
/**
 * Created by PhpStorm.
 * User: waled
 * Date: 04/04/2018
 * Time: 15:16
 */

namespace TSI\Auth\Infrastructure\HttpClient;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function send(RequestInterface $request): ResponseInterface;
}