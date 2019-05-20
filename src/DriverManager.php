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
     * @var int maximum amount of stops in a day
     */
    const MAX_STOPS = 480;

    /**
     * @var string expected result when there is no way of learning all gossips the whole day
     */
    const MIN_NEVER = 'never';

    /**
     * @var Driver[] $drivers collection of all drivers
     */
    private $drivers;

    /**
     * @var string[] $gossips all possible gossips
     */
    private $gossips;

    /**
     * DriverManager constructor.
     */
    public function __construct()
    {
        $this->drivers = [];
        $this->gossips = [];
    }

    /**
     * Creates new driver and adds him to this collection.
     *
     * @param array $route route for new driver
     */
    public function addDriver(array $route): void
    {
        $driver = new Driver($route);
        $this->drivers[] = $driver;
        $this->gossips = array_merge($this->gossips, $driver->getGossips());
    }

    /**
     * Gets minimum amount of stops for drivers to know all gossips.
     * May return 'never' if there is no way of doing so.
     *
     * @return int|string minimum number of stops or 'never'
     */
    public function getMinimumStops()
    {
        $stops = 0;
        for ($i = 0; $i < self::MAX_STOPS; $i++) {
            $stops++;
            $this->handleCurrentStop();
            if ($this->allDriversKnowEverything()) {
                return $stops;
            }
            $this->nextStop();
        }
        return self::MIN_NEVER;
    }

    /**
     * handles current stop, exchanges gossips between drivers on same stops.
     */
    private function handleCurrentStop(): void
    {
        for ($i = 0; $i < count($this->drivers); $i++) {
            for ($j = $i + 1; $j < count($this->drivers); $j++) {
                if ($this->drivers[$i]->isOnSameStop($this->drivers[$j])) {
                    $this->drivers[$i]->exchangeGossips($this->drivers[$j]);
                }
            }
        }
    }

    /**
     * Checks whether every driver knows every gossip.
     *
     * @return bool true if every driver knows every gossip
     */
    private function allDriversKnowEverything(): bool
    {
        for ($i = 0; $i < count($this->drivers); $i++) {
            for ($j = $i + 1; $j < count($this->drivers); $j++) {
                if (!$this->drivers[$i]->knowsGossips($this->gossips)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Drives all drivers to next stop.
     */
    private function nextStop(): void
    {
        foreach ($this->drivers as $driver) {
            $driver->nextStop();
        }
    }
}
