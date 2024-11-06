<?php

namespace App\Domain\Services;

interface Uuid
{
    public function generateV4(): string;
    public function isValid(string $uuid): bool;
}