<?php
class Fruit
{
    public $name;
    public $color;
    public function __construct($name, $color)
    {
        $this->name = $name;
        $this->color = $color;
        $this->intro();
    }
    final protected function intro()
    {
        echo "The fruit is {$this->name} and the color is {$this->color}.";
    }
}

// Strawberry is inherited from Fruit
class Strawberry extends Fruit
{
    public function message()
    {
        echo "Am I a fruit or a berry? ";
    }

    public function intro()
    {
        echo "Second intro";
    }

    public function newIntro()
    {
        return $this->intro();
    }
}

class mango extends Strawberry {}

$strawberry = new Strawberry("Strawberry", "red");
// $strawberry->message();
echo '<br>';
// $strawberry->intro();
$strawberry->newIntro();

echo '<br>';
echo '<br>';
