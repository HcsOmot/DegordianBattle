<?php
/**
 * Created by PhpStorm.
 * User: tomo
 * Date: 01.10.15.
 * Time: 14:43
 */

namespace DegordianBattle\interfaces;


/**
 * Interface iUnit
 * @package battle\interfaces
 */

use DegordianBattle\classes\Army;

/**
 * Interface iUnit
 * @package battle\classes\interfaces
 */
interface Unit
{
    /**
     * @return mixed
     */
    public function getHealth();

    /**
     * @return mixed
     */
    public function getMaxHealth();

    /**
     * @param $damage
     * @return mixed
     */
    public function reduceHealth($damage);
    /**
     * Perform default action for each unit type
     *
     * @param Army $targetArmy
     * @return mixed
     */
    public function performDefault(Army $targetArmy);

    /**
     * @param Army $army
     * @return mixed
     */
    public function setArmy(Army $army);

    /**
     * @return Army
     */
    public function getArmy();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return int
     */
    public function getDefense();

    /**
     * @return int
     */
    public function getAggression();

    /**
    * @param int $unitID
     */
    public function setUnitID($unitID);

    /**
     * @return int
     */
    public function getUnitID();

    /**
     * @return boolean
     */
    function getStatus();

    /**
     * Check to see if the unit is alive or if it took too much beating
     *
     * @return bool
     */
    public function isAlive();

    /**
     * Get unit's damage capability
     * @return mixed
     */
    public function getDamage();

    /**
     * Get unit's value index
     *
     * @return int
     */
    public function getValueIndex();



}