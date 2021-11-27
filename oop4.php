<?php
interface Animal
{
  public function makeSound();
  public function makeSound1();
  public function makeSound2();
}

class Goodbye
{
  const LEAVING_MESSAGE = "Thank you for visiting W3Schools.com!";
}

class Cat extends Goodbye implements Animal
{
  public function makeSound()
  {
    echo parent::LEAVING_MESSAGE;
    echo "Meow";
  }
  public function makeSound1()
  {
    echo "Meow";
  }
  public function makeSound2()
  {
    echo "Meow";
  }
}

$animal = new Cat();
$animal->makeSound();
