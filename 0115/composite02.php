<?php
/*
*@description strict add unit with archer
*/
abstract class Unit {
  abstract function bombardStrength();

  public function addUnit( Unit $unit )
  {
    throw new UnitException( get_class($this). " is a leaf");
  }

  public function removeUnit( Unit $unit )
  {
    throw new UnitException( get_class($this). " is a leaf");
  }


}

class Army extends Unit {
  private $units = array();

  public function addUnit( Unit $unit )
  {
    if( in_array( $unit, $this->units, true) )
    {
      return;
    }
    $this->units[] = $unit;
  }

  public function removeUnit(Unit $unit)
  {
    $index = array_search($unit, $this->units);
    // fixed array_udiff bug
    $this->units = array_splice($this->units, 1, $index);
    // $this->units = array_udiff($this->units, [$unit], function ($a, $b){
    //   return ($a === $b) ? 0 : 1;
    // });

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

// archer
class Archer extends Unit {
  public function bombardStrength()
  {
    return 4;
  }

}

// laser cannon
class LaserCannonUnit extends Unit {
  public function bombardStrength()
  {
    return 55;

  }

}

// start runing script test

//  create an army
$main_army = new Army();

// add some units
$main_army->addUnit( new Archer() );
$main_army->addUnit( new LaserCannonUnit() );

// create a new army
$sub_army = new Army();
$sub_army->addUnit( new Archer() );
$sub_army->addUnit( new Archer() );
$sub_army->addUnit( new Archer() );

// add the second army to the first
$main_army->addUnit( $sub_army );

$main_army->removeUnit( $sub_army );


// all the calcualtions handled behind the scenes
print "attacking with strength: {$main_army->bombardStrength()}\n";





?>
