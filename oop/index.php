<?php

// Or, using an anonymous function as of PHP 5.3.0
spl_autoload_register(
    function ($class) {
        require 'classes/' . str_replace("\\", DIRECTORY_SEPARATOR, $class) . '.php';
    }
);


$new = new \App\neww();
$mohamed = new \App\Model\mohamed();

// var_dump($new);