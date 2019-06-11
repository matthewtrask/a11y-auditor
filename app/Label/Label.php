<?php

declare(strict_types=1);

namespace App\Label;

class Label
{
    /** @var string */
    private $name;

    /** @var string */
    public $color;

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
}
