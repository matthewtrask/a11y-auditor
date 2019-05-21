<?php

declare(strict_types=1);

namespace App\Label;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;

class LabelManager
{
    public const LABELS_ENDPOINT = '/repos/%s/%s/labels';

    public const GET = 'get';

    public const POST = 'post';

    /** @var Client */
    private $client;

    /** @var Yaml */
    private $yaml;

    /** @var array */
    private $defaultGithubLabels = [
        'bug',
        'duplicate',
        'enhancement',
        'good first issue',
        'help wanted',
        'invalid',
        'question',
        'wontfix'
    ];

    public function __construct(Client $client, Yaml $yaml)
    {
        $this->client = $client;
        $this->yaml = $yaml;
    }

    public function getRepositoryIssueLabels() : Collection
    {
        $data = $this->yaml->parseFile(__DIR__ . '/../../data/labels.yml');

        $collection = new Collection();

        foreach($data as $issueLabel) {
            $label = new Label();
            $label->setName($issueLabel['name']);
            $label->setColor($issueLabel['color']);

            $collection->add($label);
        }

        return $collection;
    }

    public function createDefaultLabels(string $repositoryName)
    {
        $labels = $this->yaml->parseFile(__DIR__ . '/../../data/labels.yml');

        foreach ($labels as $label) {
            if (!in_array($label['name'], $this->defaultGithubLabels)) {
                $this->client->request(self::POST, $this->buildGetLabelsUri($repositoryName), [
                    'headers' => [
                        'Authorization' => 'token ' . $this->getGithubToken()
                    ],
                    'body' => json_encode([
                        'name' => $label['name'],
                        'color' => $label['color'],
                        'default' => $label['default'],
                    ])
                ]);
            }
        }
    }

    public function createLabel()
    {
        //
    }

    private function buildGetLabelsUri(string $repoName) : string
    {
        return $this->getGithubUri() . sprintf(self::LABELS_ENDPOINT,$this->getGithubUserName(), $repoName);
    }

    private function getGithubUri() : string
    {
        return (string) config('github.github_uri');
    }

    private function getGithubToken() : string
    {
        return (string) config('github.github_personal_access_token');
    }

    private function getGithubUsername() : string
    {
        return (string) config('github.github_username');
    }
}