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
     * @param int|string $expected
     */
    public function testDriverManager(array $routes, $expected)
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
        yield 'two drivers, short routes' => [
            'routes' => [
                [2, 1],
                [1]
            ],
            'expected' => 2
        ];
        yield 'three varying drivers' => [
            'routes' => [
                [3, 1, 2, 3],
                [3, 2, 3, 1],
                [4, 2, 3, 4, 5]
            ],
            'expected' => 5
        ];
        yield 'never' => [
            'routes' => [
                [2, 1, 2],
                [5, 2, 8]
            ],
            'expected' => DriverManager::MIN_NEVER
        ];
    }
}
