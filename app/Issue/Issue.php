<?php

declare(strict_types=1);

namespace App\Issue;

class Issue
{
    public const DESCRIPTION = '## Description';
    public const CURRENT_CODE = '## Current Code';
    public const SOLUTION = '## Solution';
    public const SUGGESTED_CODE = '## Suggested Code';
    public const AFFECTED_COMMUNITIES = '## Affected Communities';
    public const ENVIRONMENT = '## Environment';

    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string */
    private $currentCode;

    /** @var string */
    private $solution;

    /** @var string */
    private $suggestedCode;

    /** @var string */
    private $affectedCommunities;

    /** @var string */
    private $environment;

    /** @var array */
    private $tags;

    /** @var array */
    private $milestone;

    /** @var int */
    private $number;

    /** @var string */
    private $combinedDescription;

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getDescription() : ? string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getCurrentCode() : ? string
    {
        return $this->currentCode;
    }

    public function setCurrentCode(? string $currentCode) : void
    {
        $this->currentCode = $currentCode;
    }

    public function getTags() : array
    {
        return $this->tags;
    }

    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    public function getMilestone() : ? array
    {
        return $this->milestone;
    }

    public function setMilestone(? array $milestone)
    {
        $this->milestone = $milestone;
    }

    public function setNumber(int $number) : void
    {
        $this->number = $number;
    }

    public function getNumber() : int
    {
        return $this->number;
    }

    public function setSolution(?string $solution) : void
    {
        $this->solution = $solution;
    }

    public function getSolution() : ? string
    {
        return $this->solution;
    }

    public function setSuggestedCode(?string $suggestedCode) : void
    {
        $this->suggestedCode = $suggestedCode;
    }

    public function getSuggestedCode() : ? string
    {
        return $this->suggestedCode;
    }

    public function setAffectedCommunities(?string $affectedCommunities) : void
    {
        $this->affectedCommunities = $affectedCommunities;
    }

    public function getAffectedCommunities() : ? string
    {
        return $this->affectedCommunities;
    }

    public function setEnvironment(?string $environment) : void
    {
        $this->environment = $environment;
    }

    public function getEnvironment() : ? string
    {
        return $this->environment;
    }

    public function setCombinedDescription(string $description) : void
    {
        $this->combinedDescription = $description;
    }

    public function getCombinedDescription() : ? string
    {
        return $this->combinedDescription;
    }
}