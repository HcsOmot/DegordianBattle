<?php

namespace DegordianBattle\abstracts;

use DegordianBattle\classes\Army;
use DegordianBattle\interfaces\Unit as iUnit;

abstract class infantryUnit implements iUnit
{
    /**
     * Unit type name
     * @var string
     */
    protected $type;

    /**
     * Unit's current health level
     *
     * @var int
     */
    protected $health;

    /**
     * Unit's max health level
     *
     * Unit can't keep increasing it's health above this limit by consuming potions or health crates.
     *
     * @var int
     */
    protected $maxHealth;

    /**
     * Unit's damage capability
     *
     * @var int
     */
    protected $damage;

    /**
     * Unit's aggression level
     *
     * @var int
     */
    protected $aggression;

    /**
     * Unit's basic defense level
     *
     * @var int
     */
    protected $defense;

    /**
     * Army to which this unit belongs to
     *
     * @var Army
     */
    protected $army;

    /**
     * Unit's status - either alive or dead
     *
     * @var boolean
     */
    protected $status = 1;

    /**
     * Unit's value index
     *
     * @var int
     */
    protected $valueIndex;

    /**
     * Unit ID
     * @var int
     */
    protected  $unitID;

    /**
     * Get unit's current health level
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * @return mixed
     */
    public function getMaxHealth()
    {
        return $this->maxHealth;
    }

    /**
     * Cause damage to the unit
     *
     * @param $damage
     * @return mixed|void
     */
    public function reduceHealth($damage)
    {
        $this->health -= $damage;
        if (!$this->isAlive()) {
            $this->setStatus(false);
            $this->getArmy()->removeUnit($this);
        }
    }

    /**
     * Heal a unit using a potion or a health crate
     *
     * Unit will be healed to the maximum health limit, regardless of the number of potions or health crates used
     *
     * @param $healthPoints
     * @return mixed|void
     */
    public function heal($healthPoints)
    {
        $currentHealth = $this->getHealth();
        $maxHealth = $this->getMaxHealth();

        $healthDiff = abs($currentHealth - $maxHealth);

        $healthPoints = ($healthPoints > $healthDiff) ? $healthDiff : $healthPoints;

        $this->health += $healthPoints;
    }

    /**
     * Set the unit's army
     *
     * @param Army $army
     * @return mixed|void
     */
    public function setArmy(Army $army)
    {
        $this->army = $army;
    }

    /**
     * Get the unit's army
     *
     * @return Army
     */
    public function getArmy()
    {
        return $this->army;
    }

    /**
     * Get unit's value index
     *
     * @return int
     */
    public function getValueIndex()
    {
        return $this->valueIndex;
    }

    /**
     * Get unit's damage capability
     * @return mixed
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * Check to see if the unit is alive or if it took too much beating
     *
     * @return bool
     */
    public function isAlive()
    {
        return ($this->getHealth() <= 0) ? false : true;
    }

    /**
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     */
    protected function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getUnitID()
    {
        return $this->unitID;
    }

    /**
     * @param int $unitID
     */
    public function setUnitID($unitID)
    {
        $this->unitID = $unitID;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getAggression()
    {
        return $this->aggression;
    }

    /**
     * @return int
     */
    public function getDefense()
    {
        return $this->defense;
    }
}