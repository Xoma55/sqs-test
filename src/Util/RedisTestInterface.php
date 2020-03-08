<?php

namespace App\Util;

use App\Data\ProductInterface;

interface RedisTestInterface
{
    public function test(string $productId): ProductInterface;
}
