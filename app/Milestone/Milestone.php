<?php

declare(strict_types=1);

namespace App\Milestone;

use DateTime;

class Milestone
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string */
    private $state;

    /** @var int */
    private $openIssues;

    /** @var int */
    private $closedIssues;

    /** @var DateTime */
    private $dueOn;

    /** @var integer */
    private $number;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getState() : ? string
    {
        return $this->state;
    }

    public function setState(string $state) : void
    {
        $this->state = $state;
    }

    public function getOpenIssues() : int
    {
        return $this->openIssues;
    }

    public function setOpenIssues(int $openIssues) : void
    {
        $this->openIssues = $openIssues;
    }

    public function getClosedIssues() : int
    {
        return $this->closedIssues;
    }

    public function setClosedIssues(int $closedIssues) : void
    {
        $this->closedIssues = $closedIssues;
    }

    public function getDueOn() : DateTime
    {
        return $this->dueOn;
    }

    public function setDueOn(DateTime $dueOn) : void
    {
        $this->dueOn = $dueOn;
    }

    public function getNumber() : int
    {
        return $this->number;
    }

    public function setNumber(int $number) : void
    {
        $this->number = $number;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }
}