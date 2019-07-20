<?php

declare(strict_types=1);

namespace App\Issue;

use App\Manager\BaseManager;
use App\Milestone\MilestoneManager;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use League\CommonMark\CommonMarkConverter;
use Symfony\Component\Yaml\Yaml;

class IssueManager extends BaseManager
{
    /* /repos/:owner/:repo/issues */
    public const ISSUES_ENDPONT = '/repos/%s/%s/issues';

    /* /repos/:owner/:repo/issues/:issue_number */
    public const ISSUE_ENDPONT = '/repos/%s/%s/issues/%s';

    /** @var MilestoneManager */
    private $milestoneManager;

    public function __construct(Client $client, MilestoneManager $milestoneManager)
    {
        parent::__construct($client);
        $this->milestoneManager = $milestoneManager;
    }

    public function createIssue(Issue $issue, string $repository): bool
    {
        $this->buildDescription($issue);

        $data = $this->getClient()->request('post', $this->buildIssuesUrl($repository), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken()
            ],
            'body' => json_encode([
                'title' => $issue->getTitle(),
                'body' => $issue->getCombinedDescription(),
                'milestone' => $issue->getMilestone()['number'],
                'labels' => $issue->getTags()
            ])
        ]);

        if ($data->getStatusCode() >= 200 && $data->getStatusCode() <= 299) {
            return true;
        }

        return false;
    }

    public function getIssuesForRepository(string $repository)
    {
        $res = $this->getClient()->request('get', $this->buildIssuesUrl($repository), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken(),
            ]
        ]);

        $collection = new Collection();

        foreach (json_decode($res->getBody()->getContents(), true) as $data) {
            $issue = new Issue();
            $issue->setTitle($data['title']);
            $issue->setMilestone($data['milestone']);
            $issue->setCombinedDescription($this->convertMarkdown($data['body']));
            $issue->setTags($data['labels']);
            $issue->setNumber($data['number']);

            $collection->add($issue);
        }

        return $collection;
    }

    public function getIssueByNumber(string $repo, int $id): Issue
    {
        $res = $this->getClient()->request('get', $this->buildIssueUrl($repo, $id), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken(),
            ]
        ]);

        $data = json_decode($res->getBody()->getContents(), true);

        $issue = new Issue();
        $issue->setId($data['id']);
        $issue->setTitle($data['title']);
        $issue->setMilestone($data['milestone']);
        $issue->setCombinedDescription($this->convertMarkdown($data['body']));
        $issue->setTags($data['labels']);
        $issue->setNumber($data['number']);

        return $issue;
    }

    private function buildIssuesUrl(string $repository): string
    {
        return $this->getGithubUri() . sprintf(self::ISSUES_ENDPONT, $this->getGithubUsername(), $repository);
    }

    private function buildIssueUrl(string $repository, int $id): string
    {
        return $this->getGithubUri() . sprintf(self::ISSUE_ENDPONT, $this->getGithubUsername(), $repository, $id);
    }

    private function buildDescription(Issue $issue) : void
    {
        $description = '';

        if ($issue->getDescription()) {
            $description .= $this->addDescription($issue->getDescription()) . PHP_EOL;
        }

        if ($issue->getCurrentCode()) {
            $description .= $this->addCurrentCode($issue->getCurrentCode()) . PHP_EOL;
        }

        if ($issue->getSolution()) {
            $description .= $this->addSolution($issue->getSolution()) . PHP_EOL;
        }

        if ($issue->getSuggestedCode()) {
            $description .= $this->addSuggestedCode($issue->getSuggestedCode()) . PHP_EOL;
        }

        if ($issue->getAffectedCommunities()) {
            $description .= $this->addAffectedCommunities($issue->getAffectedCommunities()) . PHP_EOL;
        }

        if ($issue->getEnvironment()) {
            $description .= $this->addEnvironment($issue->getEnvironment()) . PHP_EOL;
        }

        $issue->setCombinedDescription($description);
    }

    private function convertMarkdown(string $markdown): string
    {
        $converter = $this->createMarkdownConverter();

        return $converter->convertToHtml($markdown);
    }

    private function addDescription(string $description) : string
    {
        return $this->buildDescriptionString($description, Issue::CURRENT_CODE);
    }

    private function addCurrentCode(string $currentCode) : string
    {
        return$this->buildDescriptionString($currentCode, Issue::CURRENT_CODE);
    }

    private function addSolution(string $solution) : string
    {
        return $this->buildDescriptionString($solution, Issue::SOLUTION);
    }

    private function addSuggestedCode(string $suggestedCode) : string
    {
        return $this->buildDescriptionString($suggestedCode, Issue::SUGGESTED_CODE);
    }

    private function addAffectedCommunities(string $affectedCommunities) : string
    {
        return $this->buildDescriptionString($affectedCommunities, Issue::AFFECTED_COMMUNITIES);
    }

    private function addEnvironment(string $environment) : string
    {
        return $this->buildDescriptionString($environment, Issue::ENVIRONMENT);
    }

    private function createMarkdownConverter(): CommonMarkConverter
    {
        return new CommonMarkConverter(['html_input' => 'escape']);
    }

    private function buildDescriptionString(string $text, string $header) : string
    {
        return sprintf(
'%s 
%s',
            $header, $text);
    }
}