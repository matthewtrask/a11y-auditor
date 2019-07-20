<?php

declare(strict_types=1);

namespace App\Comment;

use App\Manager\BaseManager;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;

class CommentManager extends BaseManager
{
    // /repos/:owner/:repo/issues/:issue_number/comments
    private const ISSUE_URL = '/repos/%s/%s/issues/%s/comments';

    // /repos/:owner/:repo/issues/:issue_number/comments
    private const COMMENT_URL = '/repos/%s/%s/issues/%s/comments';

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function getCommentsForIssue(string $repository, int $issueNumber) : Collection
    {
        $res = $this->getClient()->request('get', $this->buildIssueUri($repository, $issueNumber), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken(),
            ]
        ]);

        $comments = new Collection();

        foreach(json_decode($res->getBody()->getContents(), true) as $data) {
            $comment = new Comment();
            $comment->setId($data['id']);
            $comment->setBody($data['body']);
            $comment->setLink($data['html_url']);
            $comment->setPostedAt(new DateTime($data['updated_at']));
            $comment->setUser($data['user']['login']);
            $comments->add($comment);
        }

        return $comments;
    }

    public function createCommentForIssue(string $body, string $repository, int $issueNumber)
    {
        $this->getClient()->request('post', $this->buildCommentUri($repository, $issueNumber), [
            'headers' => [
                'Authorization' => 'token ' . $this->getGithubToken(),
            ],
            'body' => json_encode([
                'body' => $body
            ])
        ]);
    }

    private function buildIssueUri(string $repository, int $issueNumber) : string
    {
        return $this->getGithubUri() . sprintf(
            self::ISSUE_URL,
                    $this->getGithubUsername(),
                    $repository,
                    $issueNumber
            );
    }

    private function buildCommentUri(string $repository, int $issueNumber) : string
    {
        return $this->getGithubUri() . sprintf(
            self::COMMENT_URL,
                $this->getGithubUserName(),
                $repository,
                $issueNumber
            );
    }
}