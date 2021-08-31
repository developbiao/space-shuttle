<?php
/**
 * @Descripiton Simple understand  Dependency Injection (DI)
 * @Author GongBiao
 */

// Define clothes interface
interface Clothes {
    public function type();
}

// Lining clothes
class LiningClothes implements Clothes {
    public  function type() {
        echo "李宁一切皆有可能!\n";
    }
}

// Adidas clothes
class AdidasClothes implements Clothes {
    public function type() {
        echo "Adidas\n";
    }
}


// Define person class
class Person {
    protected $clothes;

    public function __construct(Clothes $clothes) {
        $this->clothes = $clothes;
    }

    public function showClothesType()
    {
        $this->clothes->type();
    }

}


// Running DI demo
$person = new Person(new LiningClothes());
$person->showClothesType();

