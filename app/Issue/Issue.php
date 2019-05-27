<?php

declare(strict_types=1);

namespace App\Issue;

class Issue
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $project;

    /** @var string */
    private $description;

    /** @var array */
    private $tags;

    /** @var array */
    private $milestone;

    /** @var int */
    private $number;

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

    public function setProject(string $project) : void
    {
        $this->project = $project;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
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
}