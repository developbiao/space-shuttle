<?php

// Define a container
class Container {
    protected $binds;
    protected $instances;

    public function bind($abstract, $concrete) {
        if ($concrete instanceof Closure) {
            $this->binds[$abstract] = $concreate;
        } else {
            $this->instances[$abstract] = $concreate;
        }
    }

    public function make($abstract, $parameters = []) {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        array_unshift($parameters, $this);

        return call_user_func_array($this->binds[$abstract], $paramters);
    }
}


interface Clothes {
    public function type();
}

// Define a clothes class
class Erke  implements Clothes{
    public function type() {
       echo "鸿星尔克To be number one!\n"; 
    } 
}

// Define a person class
class Person {
    protected $clothes;

    public function __consturct(Clothes $clothes)
    {
        $this->clothes = $clothes;
    }

    public function show()
    {
        $this->clothes->type();
    }
}


// ==== Demo ====
$container = new Container();
$container->bind('Clothes', function($container) {
    return new Erke();
});

$container->bind('Person', function($container, $module) {
    return new Person($container->make($module));
});

$person = $container->make('Person', ['Clothes']);
$person->show();

