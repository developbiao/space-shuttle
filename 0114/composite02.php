<?php
abstract class Unit {
  abstract function addUnit(Unit $unit);
  abstract function removeUnit(Unit $unit);
  abstract function bombardstrength();

}

class Army extends Unit {
  private $units = array();

  public function addUnit(Unit $unit)
  {
    if( in_array( $unit, $this->units, true) )
    {
      return;
    }

    $this->units[] = $unit;

  }

  public function removeUnit(Unit $unit)
  {
    $this->units = array_udiff( $this->units, array( $unit ), function ($a, $b) {
      return ($a === $b) ? 0 : 1;
    } );

  }

  public function bombardStrength()
  {
    $ret = 0;
    foreach ( $this->units as $unit )
    {
      $ret += $unit->bombardStrength();

    }

    return $ret;
  }


}

// quick exmaple classes
class Tank extends Unit {
  public function addUnit(Unit $unit) {}

  public function removeUnit(Unit $unit) {}

  public function bombardStrength()
  {
    return 4;
  }

}

class Soldier extends Unit {
  public function addUnit(Unit $unit) {}

  public function removeUnit(Unit $unit) {}

  public function bombardStrength()
  {
    return 8;
  }

}

# script demo
$tank = new Tank();
$tank2 = new Tank();
$tank3 = new Tank();
$soldier = new Soldier();

$army = new Army();
$army->addUnit( $soldier );
$army->addUnit( $tank );
$army->addUnit( $tank2 );
$army->addUnit( $tank3 );

echo "------ Before army-------\n";
//print_r( $army);
echo $army->bombardStrength() . PHP_EOL;


echo "------ After army-------\n";
$army->removeUnit( $tank2 );
//print_r( $army);
echo $army->bombardStrength() . PHP_EOL;


?>
