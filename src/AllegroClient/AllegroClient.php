<?php

declare(strict_types=1);

namespace Lkula\AllegroCategories\AllegroClient;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AllegroClient
 *
 * @package LKula\AllegroCategories\AllegroClient
 */
class AllegroClient
{
    private const BASE_URI = 'https://api.allegro.pl';

    private Client $client;
    private string $accessToken;

    public function __construct(string $accessToken)
    {
        $this->client = new Client(['base_uri' => self::BASE_URI]);
        $this->accessToken = $accessToken;
    }

    protected function get(string $route, array $query = [], array $headers = []): ResponseInterface
    {
        $defaultHeaders = [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'ContentType' => 'application/vnd.allegro.public.v1+json',
        ];

        return $this->client->request('GET', $route, [
            'headers' => array_merge($defaultHeaders, $headers),
            'query' => $query
        ]);
    }
}