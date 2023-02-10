<?php

// staging/src/Message/UpdateNotifier.php

namespace App\Message;

class UpdateNotifier
{
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
