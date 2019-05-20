<?php

/**
 * Basic test suite for Driver class.
 */

namespace Test;

use App\Driver;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * Class DriverTest
 * @package Test
 */
class DriverTest extends TestCase
{
    /**
     * Tests moving driver to next stop(s).
     *
     * @dataProvider nextStopsProvider
     *
     * @param array $route this drivers route
     * @param int $nextStops how many stops should we move driver to
     * @param int $expected current driver's stop number
     */
    public function testNextStops(array $route, int $nextStops, int $expected)
    {
        $driver = new Driver($route);
        for ($i = 0; $i < $nextStops; $i++) {
            $driver->nextStop();
        }
        $this->assertEquals($expected, $driver->getCurrentStop());
    }

    /**
     * Tests driver knowing all gossips.
     *
     * @dataProvider exchangeProvider
     *
     * @param int $numberOfDrivers
     * @param bool $expected
     */
    public function testDriverKnowsAllGossips(int $numberOfDrivers, bool $expected)
    {
        $gossips = [];
        $drivers = [];
        for ($i = 0; $i < $numberOfDrivers; $i++) {
            $driver = new Driver([1]);
            $drivers[] = $driver;
            $gossips = array_merge($gossips, $driver->getGossips());
        }
        for ($i = 0; $i < count($drivers); $i++) {
            for ($j = $i + 1; $j < count($drivers); $j++) {
                $drivers[$i]->exchangeGossips($drivers[$j]);
            }
        }
        if ($expected) {
            $this->assertTrue(end($drivers)->knowsGossips($gossips));
        } else {
            $this->assertFalse(end($drivers)->knowsGossips($gossips));
        }
    }

    /**
     * Tests whether two drivers are on the same stop.
     *
     * @dataProvider sameStopProvider
     *
     * @param array $routes
     * @param int $nextStops
     * @param bool $expected
     */
    public function testSameStop(array $routes, int $nextStops, bool $expected)
    {
        $drivers = [];
        foreach ($routes as $route) {
            $drivers[] = new Driver($route);
        }
        for ($i = 0; $i < $nextStops; $i++) {
            foreach ($drivers as $driver) {
                $driver->nextStop();
            }
        }
        if ($expected) {
            $this->assertTrue($drivers[0]->isOnSameStop($drivers[1]));
        } else {
            $this->assertFalse($drivers[0]->isOnSameStop($drivers[1]));
        }
    }

    /**
     * Provides data for testing moving to next stop.
     *
     * @return Generator
     */
    public function nextStopsProvider()
    {
        yield 'no stops' => [
            'route' => [1],
            'nextStops' => 0,
            'expected' => 1
        ];
        yield 'next stop' => [
            'route' => [1, 2],
            'nextStops' => 1,
            'expected' => 2
        ];
        yield 'route wrap' => [
            'route' => [1, 2],
            'nextStops' => 2,
            'expected' => 1
        ];
    }

    /**
     * Provides data for exchanging gossips between drivers.
     *
     * @return Generator
     */
    public function exchangeProvider()
    {
        yield 'single driver' => [
            'numberOfDrivers' => 1,
            'expected' => true
        ];
        yield 'five drivers' => [
            'numberOfDrivers' => 5,
            'expected' => true
        ];
    }

    /**
     * Provides data for checking if two drivers are on the same stop
     * after some steps.
     *
     * @return Generator
     */
    public function sameStopProvider()
    {
        yield 'same initial' => [
            'routes' => [
                [1],
                [1]
            ],
            'nextStops' => 0,
            'expected' => true
        ];
        yield 'next stop' => [
            'routes' => [
                [1, 2],
                [1, 3]
            ],
            'nextStops' => 1,
            'expected' => false
        ];
    }
}
