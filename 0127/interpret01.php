<?php
abstract class Expression
{
  private static $keycount = 0;
  private $key;

  abstract function interpret(Context $context);

  public function getKey()
  {
    if( !isset( $this->key ) )
    {
      self::$keycount++;
      $this->key = self::$keycount;
    }
    return $this->key;
  }

}

class LiteralExpression extends Expression
{
  private $value;

  public function __construct($value)
  {
    $this->value = $value;
  }

  public function interpret( Context $context )
  {
    $context->replace($this, $this->value);
  }

}

class Context
{
  private $expressionstore = array();
  public function replace(Expression $exp, $value)
  {
    $this->expressionstore[$exp->getKey()] = $value;
  }

  public function lookup(Expression $exp)
  {
    return $this->expressionstore[$exp->getKey()];
  }

}

$context = new Context();
$literal = new LiteralExpression('two');
$literal->interpret( $context );

print $context->lookup( $literal ) . PHP_EOL;


?>
