<?php
/*
*@Description vaiable expression
*@Author: Gong Biao
*@Date: 2019/01/27
*/
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

// Varibale expression
class VariableExpression extends Expression
{
  private $name;
  private $val;

  public function __construct($name, $val = null)
  {
    $this->name = $name;
    $this->val = $val;

  }

  public function interpret(Context $context)
  {
    if( !is_null($this->val) )
    {
      $context->replace($this, $this->val);
      $this->val = null;
    }

  }

  public function getKey()
  {
    return $this->name;

  }

  public function setVal($value)
  {
      $this->val = $value;

  }

}

// running script test
$context = new Context();
$myvar = new VariableExpression('input', 101);
$myvar->interpret($context);

print $context->lookup($myvar) . PHP_EOL;



?>
