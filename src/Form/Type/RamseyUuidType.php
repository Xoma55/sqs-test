<?php

namespace App\Form\Type;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RamseyUuidType extends TextType
{

    /**
     * @param mixed $value
     * @return mixed|\Ramsey\Uuid\UuidInterface
     * @throws \Exception
     */
    public function transform($value)
    {
        return Uuid::fromString($value);
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value)
    {
        return $value->getFields()->getValue();
    }
}

