<?php

namespace App\Data;

interface ProductInterface
{
    public function getId(): string;

    public function getName(): string;
}
