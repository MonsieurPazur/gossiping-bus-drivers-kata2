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
    public function testExchangeGossips()
    {
        // Creating three drivers
        // First one knows only his gossip
        $driverOne = new Driver([1]);

        // Those two should exchange gossips
        $driverTwo = new Driver([1]);
        $driverThree = new Driver([1]);

        $gossips = $driverTwo->getGossips();

        $gossips = array_merge($gossips, $driverThree->getGossips());
        $driverTwo->exchangeGossips($driverThree);

        // Second and third should know the same gossips
        $this->assertEquals($gossips, $driverThree->getGossips());
        $this->assertEquals($gossips, $driverTwo->getGossips());

        // First should know only his
        $this->assertNotEquals($gossips, $driverOne->getGossips());
    }

    /**
     * Tests driver knowing all gossips.
     */
    public function testDriverKnowsAllGossips()
    {
        $allGossips = [];
        $driverOne = new Driver([1]);
        $driverTwo = new Driver([1]);
        $driverThree = new Driver([1]);

        $allGossips = array_merge($allGossips, $driverOne->getGossips());
        $allGossips = array_merge($allGossips, $driverTwo->getGossips());
        $allGossips = array_merge($allGossips, $driverThree->getGossips());

        $driverOne->exchangeGossips($driverTwo);
        $driverThree->exchangeGossips($driverTwo);

        $this->assertTrue($driverThree->knowsGossips($allGossips));
    }

    public function testSameStop()
    {
        $driverOne = new Driver([1]);
        $driverTwo = new Driver([1]);
        $this->assertTrue($driverOne->isOnSameStop($driverTwo));


        $driverOne = new Driver([1, 2]);
        $driverOne->nextStop();
        $driverTwo = new Driver([1, 3]);
        $driverTwo->nextStop();
        $this->assertFalse($driverOne->isOnSameStop($driverTwo));
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
