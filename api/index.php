<?php
require 'vendor/autoload.php';

// Create and configure Slim app
$app = new \Slim\App;

//Autoload custom classes
include_once("load.php");

// Define app routes
$app->get('/user/logincheck', function ($request, $response, $args) {
    $user = new User();
    $vars = [
        "email" => "newvar",
        "password" => "wrongpass",
    ];
    //$user->setAttributes($vars);
    $user->getByPk(5);
    $user->save();
    var_dump($user);
    //return $response->write("Hello " . $args['name']);
});

// Run app
$app->run();