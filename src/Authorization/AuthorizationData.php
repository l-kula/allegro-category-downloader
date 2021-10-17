<?php

declare(strict_types=1);

namespace Lkula\AllegroCategories\Authorization;

/**
 * Class AuthorizationData
 *
 * @package Lkula\AllegroCategories
 */
class AuthorizationData
{
    private string $accessToken;
    private string $tokenType;
    private int $expiresIn;
    private string $scope;

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * @param string $tokenType
     */
    public function setTokenType(string $tokenType): void
    {
        $this->tokenType = $tokenType;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     */
    public function setExpiresIn(int $expiresIn): void
    {
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     */
    public function setScope(string $scope): void
    {
        $this->scope = $scope;
    }
}