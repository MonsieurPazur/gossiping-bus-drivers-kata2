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
     * Tests gossips and relations between drivers.
     */
    public function testGossips()
    {
        $gossips = [];
        $driver = new Driver([1]);
        $gossips = $driver->getGossips();
        $this->assertEquals($gossips, $driver->getGossips());
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
}
