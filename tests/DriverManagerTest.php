<?php

/**
 * Basic test suite for working with collection of Drivers.
 */

namespace Test;

use App\DriverManager;
use PHPUnit\Framework\TestCase;

/**
 * Class DriverManagerTest
 * @package Test
 */
class DriverManagerTest extends TestCase
{
    public function testDriverManager()
    {
        $manager = new DriverManager();
        $manager->addDriver([1]);
        $manager->addDriver([2]);
        $this->assertTrue(true);
    }
}
