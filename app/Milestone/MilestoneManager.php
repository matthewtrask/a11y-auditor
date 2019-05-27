<?php

declare(strict_types=1);

namespace App\Milestone;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;

class MilestoneManager
{
    // /repos/:owner/:repo/milestones
    private const MILESTONE_GET = '/repos/%s/%s/milestones';

    /** @var Client */
    private $client;

    /** @var Yaml */
    private $yaml;

    public function __construct(Client $client, Yaml $yaml)
    {
        $this->client = $client;
        $this->yaml = $yaml;
    }

    public function getMilestones() : Collection
    {
        $milestones = $this->yaml->parseFile(__DIR__ . '/../../data/milestones.yml');

        $collection = new Collection();

        foreach($milestones as $data) {
            $milestone = new Milestone();
            $milestone->setNumber($data['number']);
            $milestone->setTitle($data['title']);
            $collection->add($milestone);
        }

        return $collection;
    }

    public function createDefaultMilestones(string $repo)
    {
        $milestones = $this->yaml->parseFile(__DIR__ . '/../../data/milestones.yml');

        foreach($milestones as $milestone) {
            $this->client->request('post', $this->buildUri($repo), [
                'headers' => [
                    'Authorization' => 'token ' . $this->getGithubToken()
                ],
                'body' => json_encode([
                    'title' => $milestone['title'],
                    'state' => $milestone['state'],
                    'description' => $milestone['description'],
                ])
            ]);
        }
    }

    public function findMilestoneForId(int $milestoneNumber) : array
    {
        $milestones = $this->yaml->parseFile(__DIR__ . '/../../data/milestones.yml');

        foreach($milestones as $milestone) {
            if ($milestoneNumber === $milestone['number']) {
                return $milestone;
            }
        }

        return [];
    }

    private function buildUri(string $repo) : string
    {
        return $this->getGithubUri() . sprintf(
            self::MILESTONE_GET,
                    $this->getGithubUsername(),
                    $repo
            );
    }

    private function getGithubUsername() : string
    {
        return (string) config('github.github_username');
    }
    
    private function getGithubUri() : string
    {
        return (string) config('github.github_uri');
    }

    private function getGithubToken() : string
    {
        return (string) config('github.github_personal_access_token');
    }
}