<?php

namespace DegordianBattle\classes;

use DegordianBattle\interfaces\Unit;

class Battle
{
    /**
     * Holds armies that take part in battle
     *
     * @var array
     */
    protected $armies = [];


    /**
     * Number of rounds fought
     *
     * @var int
     */
    protected $rounds = 0;

    /**
     * Add army to the battle
     * @param Army $army
     */
    public function addArmy(Army $army)
    {
        $this->armies[] = $army;
        $armyID = max(array_keys($this->armies));
        $army->setArmyID($armyID);
    }

    /**
     * Start the battle
     */
    public function engageInBattle()
    {
        $this->sortArmiesByAggression($this->armies);
        while ($this->remainingArmies()) {
            echo "<h4>round $this->rounds</h4>";
            $this->rounds++;
            $this->takeTurns();
        }

        $victor = $this->getVictor();

        echo PHP_EOL . " all over!!<h2 style='color:red'>" . $victor->getName() . "</h2> cripple away, but at least they're not food for the vultures... THEY WON!!";

    }

    /**
     * Checks to see if both armies are still fighting
     * @return bool
     */
    public function remainingArmies()
    {
        foreach ($this->armies as $army) {
            /** @var $army Army */
            if (!$army->isAlive()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Armies take turns attacking, while the other side just takes it like a big boy...
     */
    public function takeTurns()
    {
        $this->rounds == 1 ?: shuffle($this->armies);
        $turns = 0;

        foreach ($this->armies as $currentArmy) {
            $turns++;
            /** @var $currentArmy Army */
            $enemyArmy = $this->getEnemyArmy($currentArmy);
            if ($currentArmy->isAlive() && $enemyArmy->isAlive()) {
                echo $currentArmy->getName() . " call the wrath of heavens upon " . $enemyArmy->getName() . PHP_EOL;
                foreach ($currentArmy->getActiveUnits() as $currentUnit) {
                    /** @var $currentUnit Unit */
                    $targetUnit = $enemyArmy->getMatchingUnit($currentUnit);
                    $currentUnit->performDefault($enemyArmy);
                    /** @var $targetUnit Unit */
                    if ($currentUnit && $targetUnit) {
                        echo $currentUnit->getType() . " from " . $currentArmy->getName() . " ranks attacks " . $targetUnit->getType() . " from " . $enemyArmy->getName() . " ranks" . PHP_EOL;
                    }
                }
                if ($turns <= count($this->armies) - 1 && $currentArmy->isAlive() && $enemyArmy->isAlive()) {
                    echo "<h5>turnaround</h5>";
                }
            }
        }

    }

    /**
     * Returns enemy army
     * @param Army $currentArmy
     * @return Army
     */
    protected function getEnemyArmy(Army $currentArmy)
    {
        $enemyArmy = NULL;
        foreach ($this->armies as $army) {
            /** @var $army Army */
            if ($currentArmy->getArmyID() != $army->getArmyID()) {
                $enemyArmy = $army;
            }
        }

        return $enemyArmy;
    }

    /**
     * Returns an array of armies, sorted descendingly by army's level of aggression
     * @param array $armies
     * @return bool
     */
    public function sortArmiesByAggression(array &$armies)
    {
//        playing with anonymous functions... looks nice. Need to practice more
        usort(/**
         * @param $a Army
         * @param $b Army
         * @return int
         */
            $armies, function ($a, $b) {
            /** @var $a Army */
            /** @var $b Army */

            if (($a->getAggressionLevel() == $b->getAggressionLevel())) {
                return 0;
            }

//            we want the array to be ordered descendingly, so we need to switch the return argument values
            return ($a->getAggressionLevel() < $b->getAggressionLevel()) ? 1 : -1;
        });
    }


    /**
     *
     */
    public function getVictor()
    {
        $armies = $this->armies;
        foreach ($armies as $army){
            /** @var $army Army */
            if (!$army->isAlive()) {
                continue;
            }
            return $army;
        }
    }

}