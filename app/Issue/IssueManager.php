<?php

declare(strict_types=1);

namespace App\Issue;

use App\Milestone\MilestoneManager;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use League\CommonMark\CommonMarkConverter;
use Symfony\Component\Yaml\Yaml;

class IssueManager
{
    /* /repos/:owner/:repo/issues */
    public const ISSUES_ENDPONT = '/repos/%s/%s/issues';

    /* /repos/:owner/:repo/issues/:issue_number */
    public const ISSUE_ENDPONT = '/repos/%s/%s/issues/%s';

    /** @var Client */
    private $client;

    /** @var MilestoneManager */
    private $milestoneManager;

    public function __construct(Client $client, MilestoneManager $milestoneManager)
    {
        $this->client = $client;
        $this->milestoneManager = $milestoneManager;
    }

    public function createIssue(Issue $issue, string $repository) : bool
    {
        $data = $this->client->request('post', $this->buildIssuesUrl($repository), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken()
            ],
            'body' => json_encode([
                'title'     => $issue->getTitle(),
                'body'      => $issue->getDescription(),
                'milestone' => $issue->getMilestone()['number'],
                'labels'    => $issue->getTags()
            ])
        ]);

        if ($data->getStatusCode() >= 200 && $data->getStatusCode() <= 299) {
            return true;
        }

        return false;
    }

    public function getIssuesForRepository(string $repository)
    {
        $res = $this->client->request('get', $this->buildIssuesUrl($repository), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken(),
            ]
        ]);

        $collection = new Collection();

        foreach(json_decode($res->getBody()->getContents(), true) as $data) {
            $issue = new Issue();
            $issue->setTitle($data['title']);
            $issue->setMilestone($data['milestone']);
            $issue->setDescription($this->convertMarkdown($data['body']));
            $issue->setTags($data['labels']);
            $issue->setNumber($data['number']);

            $collection->add($issue);
        }

        return $collection;
    }

    public function getIssueByNumber(string $repo, int $id) : Issue
    {
        $res = $this->client->request('get', $this->buildIssueUrl($repo, $id), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken(),
            ]
        ]);

        $data = json_decode($res->getBody()->getContents(), true);

        $issue = new Issue();
        $issue->setTitle($data['title']);
        $issue->setMilestone($data['milestone']);
        $issue->setDescription($this->convertMarkdown($data['body']));
        $issue->setTags($data['labels']);
        $issue->setNumber($data['number']);

        return $issue;
    }

    public function editIssue()
    {

    }

    private function buildIssuesUrl(string $repository) : string
    {
        return $this->getGithubUri() . sprintf(self::ISSUES_ENDPONT, $this->getGithubUsername(), $repository);
    }

    private function buildIssueUrl(string $repository, int $id) : string
    {
        return $this->getGithubUri() . sprintf(self::ISSUE_ENDPONT, $this->getGithubUsername(), $repository, $id);
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

    private function convertMarkdown(string $markdown) : string
    {
        $converter = $this->createMarkdownConverter();

        return $converter->convertToHtml($markdown);
    }

    private function createMarkdownConverter() : CommonMarkConverter
    {
        return new CommonMarkConverter(['html_input' => 'escape']);
    }

    private function findMilestone(int $milestoneId) : array
    {

    }
}