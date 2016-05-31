<?php

namespace DegordianBattle\classes;

use DegordianBattle\abstracts\infantryUnit as Unit;

class Druid extends  Unit
{
    protected $health = 100;
    protected $maxHealth = 100;
    protected $damage = 25;
    protected $aggression = 51;
    protected $valueIndex = 1;

    protected $type = "Druid";

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
     * @return mixed|void
     */
    public function attack(Army $targetArmy)
    {
        $targetUnit = $targetArmy->getMatchingUnit($this);
        if (!empty($targetUnit)) {
            $targetUnit->reduceHealth($this->getDamage());
        }
    }
}