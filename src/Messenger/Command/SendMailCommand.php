<?php

namespace App\Messenger\Command;

class SendMailCommand implements SendMailCommandInterface
{
    /** @var string */
    private $email;

    /** @var string */
    private $message;

    public function __construct(string $email, string $message)
    {
        $this->message = $message;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
