<?php

declare(strict_types=1);

namespace App\Milestone;

use App\Manager\BaseManager;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;

class MilestoneManager extends BaseManager
{
    // /repos/:owner/:repo/milestones
    private const MILESTONE_GET = '/repos/%s/%s/milestones';

    /** @var Yaml */
    private $yaml;

    public function __construct(Client $client, Yaml $yaml)
    {
        parent::__construct($client);
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
            $milestone->setDescription($data['description']);
            $collection->add($milestone);
        }

        return $collection;
    }

    public function createDefaultMilestones(string $repo)
    {
        $milestones = $this->yaml->parseFile(__DIR__ . '/../../data/milestones.yml');

        foreach($milestones as $milestone) {
            $this->getClient()->request('post', $this->buildUri($repo), [
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

    public function getMilestonesForRepository(string $repo) : Collection
    {
        $res = $this->getClient()->request('get', $this->buildUri($repo), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken()
            ],
        ]);

        $collection = new Collection();

        foreach (json_decode($res->getBody()->getContents(), true) as $data) {
            $milestone = new Milestone();
            $milestone->setTitle($data['title']);
            $milestone->setNumber($data['number']);
            $milestone->setDescription($data['description']);
            $milestone->setOpenIssues($data['open_issues']);
            $collection->add($milestone);
        }

        return $collection;
    }

    private function buildUri(string $repo) : string
    {
        return $this->getGithubUri() . sprintf(
            self::MILESTONE_GET,
                    $this->getGithubUsername(),
                    $repo
            );
    }
}