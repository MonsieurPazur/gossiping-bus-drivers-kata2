<?php

/**
 * Basic test suite for Driver class.
 */

namespace Test;

use App\Driver;
use PHPUnit\Framework\TestCase;

/**
 * Class DriverTest
 * @package Test
 */
class DriverTest extends TestCase
{
    public function testDriver()
    {
        $driver = new Driver([1]);
        $this->assertEquals(1, $driver->getCurrentStop());
    }
}
