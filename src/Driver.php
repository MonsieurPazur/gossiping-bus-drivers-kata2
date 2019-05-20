<?php

/**
 * Driver class, has a route to follow in each step and knows some gossips.
 */

namespace App;

/**
 * Class Driver
 * @package App
 */
class Driver
{
    /**
     * @var array $route consists of numbered stops for driver to follow
     */
    private $route;

    /**
     * @var int $currentStop index of this driver's current stop
     */
    private $currentStop;

    /**
     * Driver constructor.
     *
     * @param array $route this driver's route to follow
     */
    public function __construct(array $route)
    {
        $this->route = $route;
        $this->currentStop = 0;
    }

    /**
     * Gets stop that this driver is currently on.
     *
     * @return int current numbered stop
     */
    public function getCurrentStop(): int
    {
        return $this->route[$this->currentStop];
    }

    /**
     * Moves driver to next stop on his route.
     */
    public function nextStop(): void
    {
        $this->currentStop = ++$this->currentStop % count($this->route);
    }
}
