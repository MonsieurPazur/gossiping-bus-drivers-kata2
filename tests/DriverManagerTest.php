<?php

/**
 * Basic test suite for working with collection of Drivers.
 */

namespace Test;

use App\DriverManager;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * Class DriverManagerTest
 * @package Test
 */
class DriverManagerTest extends TestCase
{
    /**
     * Tests minimum amount of stops for drivers to know all gossip.
     *
     * @dataProvider driversProvider
     *
     * @param array $routes
     * @param int $expected
     */
    public function testDriverManager(array $routes, int $expected)
    {
        $manager = new DriverManager();
        foreach ($routes as $route) {
            $manager->addDriver($route);
        }
        $this->assertEquals($expected, $manager->getMinimumStops());
    }

    /**
     * Provides data for calculating minimum amount of stops for drivers to know all gossips.
     *
     * @return Generator
     */
    public function driversProvider()
    {
        yield 'two drivers, shortest route' => [
            'routes' => [
                [1],
                [1]
            ],
            'expected' => 1
        ];
    }
}
