<?php

// unit excepint
class UnitException extends Exception {

}

// unit
abstract class Unit {
  public function getComposite() {
    return null;

  }

  abstract function bombardStrength();

}

// composite unit
abstract class CompositeUnit extends Unit {
  private $units = array();

  public function getComposite()
  {
    return $this;
  }

  protected function unitis()
  {
    return $this->units;

  }

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
    $this->units = array_splice($this->units, 1, $index);

  }



}

// Archer
class Archer extends Unit {

  public function bombardStrength()
  {
    return 6;
  }

}

// Cavalry
class Cavalry extends Unit {

  public function bombardStrength()
  {
    return 33;
  }

}

// TroopCarrier
class TroopCarrier {

  public function addUnit(Unit $unit)
  {
    if( $unit instanceof Cavalry )
    {
      throw new UnitException("Can't get a horse on the vehicle");
    }

    super::addUnit( $unit );
  }

}


// Composite pattern test
$tc = new TroopCarrier();

$tc->addUnit( new Archer() );
$tc->addUnit( new Archer() );
$tc->addUnit( new Archer() );

// $ca = new Cavalry();
// $tc->addUnit($ca);

//  计算总的战斗力 
// all the calcualtions handled behind the scenes
print "attacking with strength: {$tc->bombardStrength()}\n";

?>
