<?php

abstract class Unit{
  abstract function bombardStrength();

}

class Archer extends Unit{
  public function bombardStrength()
  {
    return 4;
  }
}

class LaserCannonUnit extends Unit{
  public function bombardStrength()
  {
    return 44;
  }

}

class Army{
  private $units = array();
  private $armies = array();

  public function addUnit(Unit $unit)
  {
    array_push( $this->units, $unit );
  }

  public function addArmy(Army $army)
  {
    array_push( $this->armies, $army);

  }

  public function bombardStrength()
  {
    $ret = 0;
    foreach( $this->units as $unit )
    {
      $ret += $unit->bombardStrength();

    }

    foreach( $this->armies as $army )
    {
      $ret += $army->bombardStrength();

    }

    return $ret;

  }
}


// runing script
$unit1 = new Archer();
$unit2 = new LaserCannonUnit();

$army = new Army();
$army->addUnit( $unit1 );
$army->addUnit( $unit2 );

print $army->bombardStrength() . PHP_EOL;

# clone army strength
$army2 = clone $army;
$army->addArmy( $army2 );
print $army->bombardStrength() . PHP_EOL;
