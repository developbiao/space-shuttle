
<?php
/*
*@Description expression demo
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
// Literal Expression
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

  // override getKey function
  public function getKey()
  {
    return $this->name;

  }

  public function setValue($value)
  {
      $this->val = $value;

  }

}

/********* Operator Expression Family *************/
// OperatorExpression
abstract class OperatorExpression extends Expression
{

  protected $l_op;
  protected $r_op;

  public function __construct(Expression $l_op, Expression $r_op)
  {
    $this->l_op = $l_op;
    $this->r_op = $r_op;
  }

  public function interpret(Context $context)
  {
    $this->l_op->interpret($context);
    $this->r_op->interpret($context);

    $result_l = $context->lookup($this->l_op);
    $result_r = $context->lookup($this->r_op);

    $this->doInterpret($context, $result_l, $result_r);


  }

  // do interpret is abstract function
  protected abstract function doInterpret(Context $context, $result_l, $result_r);

}

// Equals Expression
class EqualsExpression extends OperatorExpression
{
  protected function doInterpret(Context $context, $result_l, $result_r)
  {
    $context->replace($this, $result_l == $result_r);

  }

}

// Boolean or expression
class BooleanOrExpression extends OperatorExpression
{
  protected function doInterpret(Context $context, $result_l, $result_r)
  {
    $context->replace($this, $result_l || $result_r);
  }

}

// Boolean and  expression
class BooleanAndExpression extends OperatorExpression
{
  protected function doInterpret(Context $context, $result_l, $result_r)
  {
    $context->replace($this, $result_l && $result_r);

  }

}

//====================
$context = new Context();
// define empty input variable
$input = new VariableExpression('input');

// define statement
$statement = new BooleanOrExpression(
  new EqualsExpression( $input, new LiteralExpression('four') ),
  new EqualsExpression( $input, new LiteralExpression('4') )

);

foreach( array('four', '4', '52') as $val )
{
  $input->setValue($val);
  print "$val:\n";

  $statement->interpret($context);
  if( $context->lookup( $statement ) )
  {
    print "top marks\n\n";
  }
  else
  {
    print "dunce hat on\n\n";

  }

}
