<?php

namespace App\Clients;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class QLSClient
{
    const URL = 'https://api.pakketdienstqls.nl/';

    public function __construct(
        private string $apiUser,
        private string $apiPassword,
    ) {}

    /**
     * Wrapper around the Guzzle/Laravel HTTP get method.
     *
     * @param  string  $endpoint
     * @param  array  $params
     * @return PromiseInterface|Response
     */
    public function get(string $endpoint, array $params = [])
    {
        return Http::withBasicAuth($this->apiUser, $this->apiPassword)
            ->get(self::URL . $endpoint, $params);
    }

    /**
     * Wrapper around the Guzzle/Laravel HTTP post method.
     *
     * @param  string  $endpoint
     * @param  array  $params
     * @return PromiseInterface|Response
     */
    public function post(string $endpoint, array $params = [])
    {
        return Http::withBasicAuth($this->apiUser, $this->apiPassword)
            ->post(self::URL . $endpoint, $params);
    }
}