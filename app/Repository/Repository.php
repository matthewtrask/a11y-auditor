<?php

declare(strict_types=1);

namespace App\Repository;

class Repository
{
    /** @var string */
    private $name;

    /** @var string */
    private $fullName;

    /** @var int */
    private $issueCount;

    /** @var string */
    private $issueUrl;

    /** @var string */
    private $description;

    /** @var string */
    private $githubLink;

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setFullName(string $fullName) : void
    {
        $this->fullName = $fullName;
    }

    public function getFullName() : string
    {
        return $this->fullName;
    }

    public function setIssueCount(int $count) : void
    {
        $this->issueCount = $count;
    }

    public function getIssueCount() : int
    {
        return $this->issueCount;
    }

    public function setIssueUrl(string $issueUrl) : void
    {
        $this->issueUrl = $issueUrl;
    }

    public function getDescription() : ? string
    {
        return $this->description;
    }

    public function setDescription(? string $description) : void
    {
        $this->description = $description;
    }

    public function getGithubLink() : string
    {
        return $this->githubLink;
    }

    public function setGithubLink(string $githubLink) : void
    {
        $this->githubLink = $githubLink;
    }
}