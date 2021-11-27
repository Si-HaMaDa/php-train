<?php

class Car
{
    function __construct($color, $doors, $owner = 0)
    {

        $this->color = $color;
        $this->doors = $doors;
        $this->owner = $owner;

        echo 'Worked!';
        return 'this is __construct';
    }

    function __destruct()
    {
        echo "The fruit is {$this->color}.";
    }

    public $color;
    public $doors;
    public $owner;
    protected $carNum = '159';
    private $carLic = '789';
    protected $pass;

    static $count = 'try';

    public function canMove($gas)
    {
        if ($gas) {
            return 'You Can move';
        } else {
            return 'You Can\'t move';
        }
    }

    public function move()
    {
        return 'Start move';
    }

    public function open()
    {
        return 'open ' . $this->doors . ' doors';
    }

    public function check()
    {
        if ($this->doors == 2) {
            return 'Cope Car';
        } elseif ($this->doors == 0) {
            return 'Sport Car';
        } else {
            return 'Normal Car';
        }
    }

    protected function pro()
    {
        if ($this->doors == 2) {
            return 'Cool car';
        } elseif ($this->doors == 0) {
            return 'Special Car';
        } else {
            return 'good Car';
        }
    }

    public function carNumShow()
    {
        if ($this->owner) {
            return 'Your Car Number is ' . $this->carNum;
        } else {
            return 'You can\'t see Car Number';
        }
    }

    static function tryStat()
    {
        // return $this->count;
        // return self::$count;
        return 'this is static function';
    }

    public function setPass($pass)
    {
        if (strlen($pass) < 6) {
            return 'Pass must be more than 6 digits';
        } else {
            $this->pass = sha1($pass);
        }
    }
}

// function any($var = '1')
// {
//     return 'Hi';
// }

// any();

$car_one = new Car('Red', '4');
$car_one->color = 'red';
// $car_one->doors = '4';


$car_two = new Car('Blue', '2');
// $car_two->color = 'blue';
// $car_two->doors = '2';


$car_three = new Car('Green', '0', 1);
// $car_three->color = 'green';
// $car_three->doors = '0';

$car_four = Car::tryStat();

echo '<pre>';
echo $car_one->pass;
// var_dump($car_four);

var_dump($car_one);
// var_dump($car_one->open());
// var_dump($car_one->check());

var_dump($car_two);
// var_dump($car_two->open());
// var_dump($car_two->check());

var_dump($car_three);
var_dump($car_three->color);
// // var_dump($car_three->carNum);
// // var_dump($car_three->carLic);
var_dump($car_three::$count);
// var_dump($car_three->open());
// var_dump($car_three->check());
// var_dump($car_three->canMove(0));
// // var_dump($car_three->pro()); // will result error because trying to access Protected method
// var_dump($car_three->carNumShow());
// // var_dump($car_three->__construct('Green', '0'));
