<?php

namespace App\Messenger\Command;

interface SaveToFileCommandInterface
{
    public function getFileName(): string;

    public function getText(): string;
}
