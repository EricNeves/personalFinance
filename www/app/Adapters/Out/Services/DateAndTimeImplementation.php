<?php

namespace App\Adapters\Out\Services;

use DateTime;
use App\Domain\Services\DateAndTime;

class DateAndTimeImplementation implements DateAndTime
{
    public function currentDateTime(): string
    {
        $dateTime = new DateTime();

        $dateTime->setTimestamp(time());

        return $dateTime->format('Y-m-d H:i:s');
    }
}