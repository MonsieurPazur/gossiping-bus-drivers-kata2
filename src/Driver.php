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
     * @var int $currentStopIndex index of this driver's current stop
     */
    private $currentStopIndex;

    /**
     * @var string[] $gossips list of gossips known to this driver
     */
    private $gossips;

    /**
     * Driver constructor.
     *
     * @param array $route this driver's route to follow
     */
    public function __construct(array $route)
    {
        $this->route = $route;
        $this->currentStopIndex = 0;
        $this->gossips = [];
        $this->initGossip();
    }

    /**
     * Gets stop that this driver is currently on.
     *
     * @return int current numbered stop
     */
    public function getCurrentStop(): int
    {
        return $this->route[$this->currentStopIndex];
    }

    /**
     * Moves driver to next stop on his route.
     */
    public function nextStop(): void
    {
        $this->currentStopIndex = ++$this->currentStopIndex % count($this->route);
    }

    /**
     * Gets list of gossips known to this driver
     *
     * @return array list of gossips known to this driver
     */
    public function getGossips(): array
    {
        return $this->gossips;
    }

    /**
     * Exchanges gossips between two drivers.
     *
     * @param Driver $another other driver to exchange gossips with
     */
    public function exchangeGossips(Driver $another): void
    {
        $commonGossips = array_unique(array_merge($this->getGossips(), $another->getGossips()));
        $this->gossips = $commonGossips;
        $another->gossips = $commonGossips;
    }

    /**
     * Checks whether this driver knows all given gossips.
     *
     * @param array $gossips gossips that we check against
     *
     * @return bool true, if this driver knows all given gossips
     */
    public function knowsGossips(array $gossips): bool
    {
        return array_diff($gossips, $this->gossips) === [];
    }

    /**
     * Checks whether this driver is on the same stop as another one.
     *
     * @param Driver $another other driver
     *
     * @return bool true if both drivers are on the same stop
     */
    public function isOnSameStop(Driver $another): bool
    {
        return $this->getCurrentStop() === $another->getCurrentStop();
    }

    /**
     * Creates pseudo-random gossip, unique to this driver.
     */
    private function initGossip(): void
    {
        $this->gossips[] = substr(md5((microtime())), 0, 8);
    }
}
