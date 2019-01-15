<?php
/*
*@description strict add unit with archer
*/
abstract class Unit {
  abstract function addUnit(Unit $unit);
  abstract function removeUnit(Unit $unit);
  abstract function bombardStrength();

}

class Army extends Unit {
  private $units = array();

  public function addUnit( Unit $unit )
  {
    if( in_array( $unit, $this->units, true) )
    {
        return;
    }
  }

  public function removeUnit(Unit $unit)
  {
    $this->units = array_udiff($this->units, [$unit], function ($a, $b){
      return ($a === $b) ? 0 : 1;
    });

  }

  public function bombardStrength()
  {
    $ret = 0;
    foreach( $this->units as $unit)
    {
      $ret += $unit->bombardStrength();
    }
    return $ret;
  }

}

class UnitException extends Exception {

}

class Archer extends Unit {
  public function addUnit( Unit $unit )
  {
    throw new UnitException( get_class($this). " is a leaf");
  }

  public function removeUnit( Unit $unit )
  {
    throw new UnitException( get_class($this). " is a leaf");
  }

  public function bombardStrength()
  {
    return 4;
  }

}

// start runing script test

$archer = new Archer();
$archer2 = new Archer();
$archer->addUnit($archer2);




?>
