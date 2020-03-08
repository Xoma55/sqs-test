<?php

namespace App\Controller;

use App\Data\ProductInterface;
use App\Util\MemcacheTestInterface;
use Symfony\Component\Cache\Exception\CacheException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MemcacheController
{
    /** @var MemcacheTestInterface */
    private $memcacheTest;

    /**
     * MemcacheController constructor.
     * @param MemcacheTestInterface $memcacheTest
     */
    public function __construct(MemcacheTestInterface $memcacheTest)
    {
        $this->memcacheTest = $memcacheTest;
    }

    /**
     * @Route("/memcache/cache", methods="GET")
     * @throws CacheException
     * @throws \Exception
     */
    public function cache()
    {
        /** @var ProductInterface $product */
        $product = $this->memcacheTest->test('03420133-ee27-48ca-8c80-8360d03c8c0b');

        return new JsonResponse((array)$product);
    }
}
