<?php

declare(strict_types=1);

namespace Lkula\AllegroCategories\Authorization;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Lkula\AllegroCategories\AllegroClient\AllegroClient;

/**
 * Class AuthorizationManager
 *
 * @package LKula
 */
class AuthorizationManager
{
    private const CLIENT_ID = '31355801e2e34f5dab318b0502b5386e';
    private const CLIENT_SECRET = 'v1XDNEtoh0thbQG23SF4nymEjP7Bis3RtLtboQ2GAcQzludhj8ZwDn8I7DjUmy3Q';

    private const BASE_URI = 'https://allegro.pl';
    private const TOKEN_URL = '/auth/oauth/token';

    private Client $client;
    private AuthorizationData $authorizationData;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => self::BASE_URI]);
    }

    /**
     * @throws GuzzleException
     */
    public function authorize(): AuthorizationData
    {
        $basicAuthorization = base64_encode(sprintf('%s:%s', self::CLIENT_ID, self::CLIENT_SECRET));
        $headers = [
            'Authorization' => "Basic {$basicAuthorization}",
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $response = $this->client->request(
            "POST",
            self::TOKEN_URL,
            ['headers' => $headers, 'query' => ['grant_type' => 'client_credentials']]
        );

        $this->buildAuthorizationData($response->getBody()->getContents());

        return $this->authorizationData;
    }

    private function buildAuthorizationData(string $jsonContent): void
    {
        $decodedJson = json_decode($jsonContent);

        $this->authorizationData = new AuthorizationData();
        $this->authorizationData->setAccessToken($decodedJson->access_token);
        $this->authorizationData->setTokenType($decodedJson->token_type);
        $this->authorizationData->setExpiresIn($decodedJson->expires_in);
        $this->authorizationData->setScope($decodedJson->scope);
    }
}