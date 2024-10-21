<?php

namespace App\Domain\Services;

interface Uuid
{
    public function generate_v4(): string;
}