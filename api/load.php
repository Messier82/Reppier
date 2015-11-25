<?php
//Reppier management system
//Design and code - M82.eu

$classesDir = scandir("./class");

foreach($classesDir as $file) {
    $length = strlen($file);
    $substring = substr($file, $length - 4, 4);
    if($substring == ".php") {
        include_once("./class/" . $file);
    }
}