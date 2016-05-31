<?php
/**
 * Created by PhpStorm.
 * User: tomo
 * Date: 01.10.15.
 * Time: 14:36
 */

require 'vendor/autoload.php';

use DegordianBattle\classes\Phalanx;
use DegordianBattle\classes\Druid;
use DegordianBattle\classes\Army;
use DegordianBattle\classes\Battle;

if (!empty($_GET)) {
    $army1Size = $_GET['army1'];
}
if (!empty($_GET)) {
    $army2Size = $_GET['army2'];
}


if(!isset($army1Size) && !isset($army2Size)){
    exit("Both armies need to have their sizes set!");
}
//phalanx
$phalanx = new Phalanx();

//druid
$druid = new Druid();

echo "<pre>";


$army1 = new Army($army1Size);
$army2 = new Army($army2Size);
//$army3 = new Army($army3Size);

$army1->registerUnitType($phalanx);
$army1->setName("Romans");

$army2->registerUnitType($druid);
$army2->setName("Gauls");


$army1->assembleTheArmy();
$army2->assembleTheArmy();

$battle = new Battle();

$battle->addArmy($army1);
$battle->addArmy($army2);

$battle->engageInBattle();

