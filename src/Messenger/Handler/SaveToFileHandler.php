<?php

namespace App\Messenger\Handler;

use App\Messenger\Command\SaveToFileCommandInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SaveToFileHandler implements MessageHandlerInterface
{
    public function __invoke(SaveToFileCommandInterface $command)
    {
        return file_put_contents($command->getFileName(), $command->getText());
    }
}
