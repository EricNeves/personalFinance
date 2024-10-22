<?php

namespace App\Domain\Services;

interface Uuid
{
    public function generateV4(): string;
}