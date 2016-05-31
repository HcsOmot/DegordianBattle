<?php


namespace DegordianBattle\classes;

use DegordianBattle\abstracts\infantryUnit as Unit;

class Army
{
    /**
     * Name of the army
     * @var string
     */
    protected $name;

    /**
     * Array that holds available unit types for this army.
     *
     * Elements of the array are Unit type objects
     * @var array
     */
    protected $availableUnitTypes = [];

    /**
     * Size of the army
     * @var int
     */
    protected $size;

    /**
     * Units comprising the army
     * @var array
     */
    protected $activeUnits = [];

    /**
     * Army ID - used to distinguish armies
     * @var int
     */
    protected $armyID;

    /**
     * Amount of cumulative aggression
     *
     * A sum of all unit's Damage capability
     * @var int
     */
    protected $aggressionLevel;



    /**
     * @param $size
     */
    public function __construct($size)
    {
        if ($size <= 0 || !$size) {
            exit("Army size must be at least 1. Like Arnold. You know, Arnold, the One-Man-Army Guy?");
        }
        $this->size = $size;
    }

    /**
     * Registers a unit type for this army
     *
     * @param Unit $unit
     */
    public function registerUnitType(Unit $unit)
    {
        $this->availableUnitTypes[] = $unit;
    }

    /**
     * Generates units for the army, based on the list of available unit types and the size of the army
     */
    public function assembleTheArmy()
    {
        for($i=1; $i <= $this->getSize(); $i++) {
            foreach ($this->availableUnitTypes as $availableUnit) {
                $this->addUnit(clone $availableUnit);
            }
        }

        $this->calculateCumulativeAggression();
    }

    /**
     * Performs calculation of army's cumulative aggression level
     */
    protected function calculateCumulativeAggression()
    {
        foreach ($this->activeUnits as $activeUnit) {
            /** @var $activeUnit Unit */
            $this->aggressionLevel += $activeUnit->getAggression();
        }

    }

    /**
     * Adds a new Unit object to the array of units comprising the army
     *
     * @param Unit $unit
     */
    protected function addUnit(Unit $unit) {
        $this->activeUnits[] = $unit;
        $unitID = max(array_keys($this->activeUnits));
        $unit->setArmy($this);
        $unit->setUnitID($unitID);
    }

    /**
     * Removes a unit from the array of active units
     * @param Unit $unit
     */
    public function removeUnit(Unit $unit)
    {
        $unitID = $unit->getUnitID();
        unset($this->activeUnits[$unitID]);
    }

    /**
     * Returns the array of all units comprising the army
     *
     * v0.1 returns all units
     * @return array
     */
    public function getActiveUnits()
    {
        return $this->activeUnits;
    }

    /**
     * Returns the army size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Returns a random unit from army
     *
     * @return Unit
     */
    public function getRandomUnit()
    {
        if (!empty($this->activeUnits[array_rand($this->getActiveUnits())])) {
            return $this->activeUnits[array_rand($this->getActiveUnits())];
        }
    }

    /**
     * Returns the army's name
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Signals if the army is still alive and kicking, i.e. does the army have any living units
     *
     * @return boolean
     */
    public function isAlive()
    {
        return count($this->getActiveUnits()) ? true : false;
    }

    /**
     * Return army ID
     * @return mixed
     */
    public function getArmyID()
    {
        return $this->armyID;
    }

    /**
     * Set army ID
     * @param mixed $armyID
     */
    public function setArmyID($armyID)
    {
        $this->armyID = $armyID;
    }

    /**
     * @return mixed
     */
    public function getAggressionLevel()
    {
        return $this->aggressionLevel;
    }

    /**
     * Return a unit with equal Unit Value Index
     * @param Unit $seekerUnit
     * @return Unit
     */
    public function getMatchingUnit(Unit $seekerUnit)
    {
        foreach ($this->getActiveUnits() as $currentUnit) {
            /** @var $currentUnit Unit */
            if (!$currentUnit->isAlive()){
                continue;
            }
            return $currentUnit->getValueIndex() == $seekerUnit->getValueIndex() ? $currentUnit : $this->getRandomUnit();
        }

    }
}