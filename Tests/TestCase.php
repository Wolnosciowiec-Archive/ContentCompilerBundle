<?php

declare(strict_types=1);

namespace Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class TestCase extends WebTestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Set up a kernel.
     */
    protected function setUp()
    {
        $client = static::createClient([
            'env' => 'test',
        ]);

        $this->container = $client->getContainer();

        parent::setUp();
    }
}
