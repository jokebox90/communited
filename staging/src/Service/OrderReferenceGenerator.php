<?php

declare(strict_types=1);

namespace App\Service;

use DateTime;
use Ramsey\Uuid\Uuid;

final class OrderReferenceGenerator
{
    public static function create(DateTime $dateTime = new DateTime())
    {
        return sprintf(
            "C%s%s",
            $dateTime->format("Ymd"),
            str_pad((string) random_int(0, 99999), 5, "0", STR_PAD_LEFT)
        );
    }
}

