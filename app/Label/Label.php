<?php

declare(strict_types=1);

namespace App\Label;

class Label
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $color;

    /** @var string */
    private $description;

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setColor(string $color) : void
    {
        $this->color = $color;
    }

    public function getColor() : string
    {
        return $this->color;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    public function getDescription() : string
    {
        return $this->description;
    }
}
