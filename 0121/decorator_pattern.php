<?php
/**
*@description Decorator pattern
*/
abstract class Tile {
  abstract function getWealthFactor();

}

class Plains extends Tile {
  private $wealthfactor = 2;
  public function getWealthFactor()
  {
    return $this->wealthfactor;

  }
}

abstract class TileDecorator extends Tile {
  protected $tile;
  public function __construct(Tile $tile)
  {
    $this->tile = $tile;

  }

}

class DiamondDecorator extends TileDecorator {
  public function getWealthFactor()
  {
    return $this->tile->getWealthFactor() + 2;
  }
}

# 北京的pollution
class PollutionDecorator extends TileDecorator {
  public function getWealthFactor()
  {
    return $this->tile->getWealthFactor() - 4;
  }
}

$tile = new Plains();
print  "Plains wealth: " . $tile->getWealthFactor() . PHP_EOL;

$tile = new DiamondDecorator( new Plains() );
print  "Diamond wealth: " . $tile->getWealthFactor() . PHP_EOL;


?>
