<?php

declare(strict_types=1);

namespace App\Manager;

use GuzzleHttp\Client;

abstract class BaseManager
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function getGithubUri() : string
    {
        return (string) config('github.github_uri');
    }

    protected function getGithubToken() : string
    {
        return (string) config('github.github_personal_access_token');
    }

    protected function getGithubUserName() : string
    {
        return (string) config('github.github_username');
    }

    protected function getClient() : Client
    {
        return $this->client;
    }

    protected function getGithubAcceptHeader() : string
    {
        return (string) config('github.github_accept_header');
    }
}