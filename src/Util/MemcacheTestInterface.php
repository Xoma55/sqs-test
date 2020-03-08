<?php

namespace App\Util;

use App\Data\ProductInterface;

interface MemcacheTestInterface
{
    public function test(string $productId): ProductInterface;
}
