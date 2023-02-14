<?php

declare(strict_types=1);

namespace App\Service;

use Ramsey\Uuid\Uuid;

final class UniqueIdGenerator
{
    public function create()
    {
        return (Uuid::uuid4())->toString();
    }
}

