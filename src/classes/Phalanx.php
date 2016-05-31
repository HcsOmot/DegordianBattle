<?php

namespace DegordianBattle\classes;

use DegordianBattle\abstracts\infantryUnit as Unit;

class Phalanx extends Unit
{
    protected $health = 100;
    protected $maxHealth = 100;
    protected $damage = 25;
    protected $aggression = 55;
    protected $valueIndex = 10;
    protected $defense = 20;

    protected $type = "Phalanx";

    /**
     * Unit performs default action
     */
    public function performDefault(Army $targetArmy)
    {
        /** @var Army $targetArmy */
        $this->attack($targetArmy);
    }

    /**
     * @param Army $targetArmy
     */
    public function attack(Army $targetArmy)
    {
        $targetUnit = $targetArmy->getMatchingUnit($this);
        if (!empty($targetUnit)) {
            $targetUnit->reduceHealth($this->getDamage());
        }
    }
}