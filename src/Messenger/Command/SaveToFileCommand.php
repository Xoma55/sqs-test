<?php

namespace App\Messenger\Command;

class SaveToFileCommand implements SaveToFileCommandInterface
{
    /** @var string */
    private $fileName;
    /** @var string */
    private $text;

    /**
     * SaveToFileCommand constructor.
     * @param string $fileName
     * @param string $text
     */
    public function __construct(string $fileName, string $text)
    {
        $this->fileName = $fileName;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
