<?php

namespace App\Domain\Entities;

use JsonSerializable;

class UserContext implements JsonSerializable
{
    public function __construct(private readonly string $id, private readonly string $email)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}