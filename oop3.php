 <?php
    // Parent class
    abstract class Car
    {
        public $name;
        public function __construct($name)
        {
            $this->name = $name;
        }
        
        abstract public function intro($n);

        public function in() {
            return 'Hi';
        }
    }

    // Child classes
    class Audi extends Car
    {
        public $new;

        public function intro($qqq)
        {
            return 'Hello';
        }
    }

    // Create objects from the child classes
    $audi = new audi("Audi");
    echo $audi->intro('ionoinlk');
    echo $audi->in();
    echo "<br>";

    ?> 