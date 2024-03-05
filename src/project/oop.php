
<?php

    // Tính Đa Hình (Polymorphism):
    interface Shape{
        public function calculateArea();
    }

    class Retangle implements Shape{
        
        private $width;
        private $height;

        public function __construct($width, $height)
        {
            $this->width = $width;
            $this->height = $height;
        }

        function calculateArea()
        {
            return $this->width * $this->height;
        }
    }

    class Cirle implements Shape{
        
        private $radius;

        public function __construct($radius)
        {
            $this->radius = $radius;
        }

        function calculateArea()
        {
            return pi() * $this->radius * $this->radius;
        }
    }

    function getArea(Shape $shape){
        return $shape->calculateArea();
    }

    // $retangle = new Retangle(5,10);
    // $cirle = new Cirle(5);
    // print_r("Retangle : " . getArea($retangle));
    // print_r(" ------------------------------------------- ");
    // print_r("Cirle : " . getArea($cirle));

    // Tính Đóng Gói (Encapsulation):
    class BankAccount{

        private $balance;

        public function __construct($balance = 0)
        {
            $this->balance = $balance;
        }
        
        public function deposit($amount){
            $this->balance += $amount;
        }

        public function withdraw($amount){
            if($this->balance <= $amount){
                echo "Insufficient funds.";
            }else{
                $this->balance -= $amount;
            }
        }
        
        public function getBalance() {
            return $this->balance;
        }
    }

    // $user01 = new BankAccount(1000);
    // $user01->deposit(200);
    // $user01->withdraw(100); 
    // print_r($user01->getBalance());

    // Tính Kế Thừa (Inheritance):


    interface Printable{
        public function infor();
    }

    abstract class Animal{
        protected $name;
        protected $color;
        protected $sound;

        public function __construct($name, $color, $sound)
        {
            $this->name = $name;
            $this->color = $color;
            $this->sound = $sound;
        }

        abstract public function makeSound();
    }

    class Dog extends Animal implements Printable{

        public function makeSound(){
           return $this->sound;
        }

        public function infor(){
            echo "Name: " . $this->name . "<br>";
            echo "Color: " . $this->color . "<br>";
            echo "Sound: " . $this->sound . "<br>";
        }
    }

    $dog = new Dog('Buddy', 'Brown', 'Woof');
    echo $dog->makeSound(). "<br>";
    echo $dog->infor();
?>