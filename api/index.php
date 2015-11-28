<?php

require 'vendor/autoload.php';

// Create and configure Slim app
$app = new \Slim\App;

//Load phpActiveRecord
require_once 'php-activerecord/ActiveRecord.php';

ActiveRecord\Config::initialize(function($cfg) {
    $cfg->set_model_directory('models');
    $cfg->set_connections(array(
        'development' => 'mysql://root:@localhost/reppier'));
});

function jsonRespond($data,$response) {
    return $response->write(json_encode($data));
}

// Define app routes
$app->get('/user/emailcheck', function ($request, $response, $args) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        return jsonRespond([
            "status" => "error",
            "error" => "Email validation failed"
        ], $response);
    }
    $userCount = User::count_by_email($email);
    if ($userCount != 1) {
        return jsonRespond(["status" => "false"], $response);
    }
    return jsonRespond(["status" => "true"], $response);

    //return $response->write("Hello " . $args['name']);
});

// Run app
$app->run();
