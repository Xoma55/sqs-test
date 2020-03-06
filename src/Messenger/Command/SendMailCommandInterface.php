<?php

namespace App\Messenger\Command;

interface SendMailCommandInterface
{
    public function getEmail(): string;

    public function getMessage(): string;

}
