<?php

/**
 * Classs for managing collection of drivers and relations between them.
 */

namespace App;

/**
 * Class DriverManager
 * @package App
 */
class DriverManager
{
    /**
     * @var Driver[] $drivers collection of all drivers
     */
    private $drivers;

    /**
     * DriverManager constructor.
     */
    public function __construct()
    {
        $this->drivers = [];
    }

    /**
     * Creates new driver and adds him to this collection.
     *
     * @param array $route route for new driver
     */
    public function addDriver(array $route): void
    {
        $this->drivers[] = new Driver($route);
    }

    public function getMinimumStops()
    {
        return 1;
    }
}
