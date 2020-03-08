<?php

namespace App\Util;

use App\Data\Product;
use App\Data\ProductInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MemcacheTest implements MemcacheTestInterface
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
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function test(string $productId): ProductInterface
    {
        $cache = $this->container->get('app.cache.products');

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
