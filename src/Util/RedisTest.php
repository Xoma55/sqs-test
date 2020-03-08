<?php

namespace App\Util;

use App\Data\Product;
use App\Data\ProductInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RedisTest implements RedisTestInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * MemcacheTest constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return Product|mixed
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function test(string $productId): ProductInterface
    {

        $cache = $this->container->get('app.cache.redis');

        $cacheProduct = $cache->getItem($productId);

        if (!$cacheProduct->isHit()) {
            $product = new Product($productId, 'Test Product');
            $cacheProduct->set($product);
            $cache->save($cacheProduct);
        } else {
            $product = $cacheProduct->get();
        }

        return $product;
    }
}
