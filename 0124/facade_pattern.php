<?php
function getProductFilelines( $file )
{
  return file( $file );

}

function getProductObjectFromId($id, $product_name)
{
  // some kind of database lookup
  return new Product($id, $product_name);
}

function getNameFromLine( $line ) {
    if ( preg_match( "/.*-(.*)\s\d+/", $line, $array ) ) {
        return str_replace( '_',' ', $array[1] );
    }
    return '';
}

function getIDFromLine( $line ) {
    if ( preg_match( "/^(\d{1,3})-/", $line, $array ) ) {
        return $array[1];
    }
    return -1;
}

class Product {
  public $id;
  public $name;

  public function __construct($id, $name)
  {
    $this->id = $id;
    $this->name = $name;
  }

}

//  外观者模式 
class ProductFacade {
  private $products = array();
  private $file;

  public function __construct( $file )
  {
    $this->file = $file;
    $this->compile();
  }

  // 这里把所有该做的事情都做好
  private function compile()
  {
    $lines = getProductFileLines( $this->file );
    foreach( $lines as $line )
    {
      $id = getIDFromLine($line);
      $name = getNameFromLine($line);
      $this->products[$id] = getProductObjectFromId($id, $name);
    }

  }

  public function getProducts()
  {
    return $this->products;

  }

  public function getProduct($id)
  {
    return $this->products[$id];
  }

}

$facade = new ProductFacade('test.txt');
$object = $facade->getProduct(123);
print_r($object);


?>
