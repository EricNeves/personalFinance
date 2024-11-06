<?php

namespace App\Domain\Services;

use DateTime;

interface DateAndTime
{
    public function currentDateTime(): string;
}