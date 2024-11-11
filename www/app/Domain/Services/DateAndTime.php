<?php

namespace App\Domain\Services;

interface DateAndTime
{
    public function currentDateTime(): string;
}