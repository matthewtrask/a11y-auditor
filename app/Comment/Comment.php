<?php

declare(strict_types=1);

namespace App\Comment;

use DateTime;

class Comment
{
    /** @var int */
    private $id;

    /** @var string */
    private $body;

    /** @var string */
    private $link;

    /** @var DateTime */
    private $postedAt;

    /** @var string */
    private $user;

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function setBody(string $body) : void
    {
        $this->body = $body;
    }

    public function getBody() : ? string
    {
        return $this->body;
    }

    public function setLink(string $link) : void
    {
        $this->link = $link;
    }

    public function getLink() : ? string
    {
        return $this->link;
    }

    public function setPostedAt(DateTime $postedAt)
    {
        $this->postedAt = $postedAt;
    }

    public function getPostedAt() : ? DateTime
    {
        return $this->postedAt;
    }

    public function setUser(string $user) : void
    {
        $this->user = $user;
    }

    public function getUser() : ? string
    {
        return $this->user;
    }
}