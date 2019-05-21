<?php

declare(strict_types=1);

namespace App\Repository;

use App\Issue\IssueManager;
use App\Label\LabelManager;
use App\Milestone\MilestoneManager;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;

class RepositoryManager
{
    public const GET = 'get';

    public const POST = 'post';

    // /repos/:owner/repos
    public const GET_REPOS_ENDPOINT = '/users/%s/repos';

    // /repos/:owner/
    public const GET_REPO_ENDPOINT = '/repos/%s/';

    public const POST_ENDPOINT = '/user/repos';

    // /repos/:owner/:repo
    public const DELETE_ENDPONT = '/repos/%s/%s';

    /** @var Client */
    private $client;

    /** @var LabelManager */
    private $labelManager;

    /** @var MilestoneManager */
    private $milestoneManager;

    public function __construct(
        Client $client,
        LabelManager $labelManager,
        MilestoneManager $milestoneManager
    ) {
        $this->client = $client;
        $this->labelManager = $labelManager;
        $this->milestoneManager = $milestoneManager;
    }

    public function getRepositories() : Collection
    {
        $data = $this->client->request(self::GET, $this->buildGetAllUri(), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken()
            ]
        ]);

        // handle pagination

        $collection = new Collection();

        foreach (json_decode($data->getBody()->getContents()) as $repo) {
            $repository = new Repository();
            $repository->setName($repo->name);
            $repository->setFullName($repo->full_name);
            $repository->setIssueCount($repo->open_issues_count);
            $repository->setIssueUrl($repo->issues_url);
            $repository->setDescription($repo->description);

            $collection->add($repository);
        }

        return $collection;
    }

    public function getRepository(string $repoName) : Repository
    {
        $data = $this->client->request(self::GET, $this->buildGetOneUri($repoName), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken()
            ]
        ]);

        $repository = new Repository();

        $repo = json_decode($data->getBody()->getContents());
        $repository->setName($repo->name);
        $repository->setFullName($repo->full_name);
        $repository->setIssueCount($repo->open_issues_count);
        $repository->setIssueUrl($repo->issues_url);
        $repository->setGithubLink($repo->html_url);


        return $repository;
    }

    public function createRepository(string $repositoryName, string $repositoryDescription) : bool
    {
        $repo = json_encode([
                'name' => $repositoryName,
                'description' => $repositoryDescription,
                'has_issues' => true,
                'auto_init' => true,
                'has_projects' => true
        ]);

        $data = $this->client->request(self::POST, $this->buildPostUri(), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken()
            ],
            'body' => $repo
        ]);

        if ($data->getStatusCode() >= 200 && $data->getStatusCode() <= 299) {
            $this->labelManager->createDefaultLabels($repositoryName);
            $this->milestoneManager->createDefaultMilestones($repositoryName);
            return true;
        }

        return false;
    }

    public function deleteRepository(string $repository)
    {
        $res = $this->client->request('DELETE', $this->buildDeleteUri($repository), [
            'hedaers' => [
                'Authorization' => 'token ' . $this->getGithubToken(),
            ]
        ]);

        return $res;
    }

    private function buildGetAllUri() : string
    {
        return $this->getGithubUri() . sprintf(self::GET_REPOS_ENDPOINT, $this->getGithubUser());
    }

    private function buildGetOneUri(string $repoName) : string
    {
        return $this->getGithubUri() . sprintf(self::GET_REPO_ENDPOINT, $this->getGithubUser()) . $repoName;
    }

    private function buildPostUri() : string
    {
        return $this->getGithubUri() . self::POST_ENDPOINT;
    }

    private function buildDeleteUri(string $repo) : string
    {
        return $this->getGithubUri() . sprintf(self::DELETE_ENDPONT, $this->getGithubUser(), $repo);
    }

    private function getGithubUri() : string
    {
        return (string) config('github.github_uri');
    }

    private function getGithubToken() : string
    {
        return (string) config('github.github_personal_access_token');
    }

    private function getGithubUser() : string
    {
        return (string) config('github.github_username');
    }
}