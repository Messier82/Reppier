<?php

require 'vendor/autoload.php';

// Create and configure Slim app
$app = new \Slim\App;

//Load phpActiveRecord
require 'php-activerecord/ActiveRecord.php';

ActiveRecord\Config::initialize(function($cfg) {
    $cfg->set_model_directory('models');
    $cfg->set_connections(array(
        'development' => 'mysql://root:@localhost/reppier'));
});

function jsonRespond($data, $response) {
    return $response->write(json_encode($data));
}

function validationResponse($bool) {
    if ($bool) {
        return "true";
    }
    return "";
}

// Define app routes
// 
// Checking for registration
// 
// Email availability checking
$app->get('/user/check/email', function ($request, $response, $args) {
    $email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
    $validate = User::checkEmailAvailability($email);
    return $response->write(validationResponse($validate));
});

// Phone availability checking
$app->get("/user/check/phone_number", function($request, $response, $args) {
    $phone = filter_input(INPUT_GET, 'phone_number', FILTER_UNSAFE_RAW);
    $validate = User::checkPhoneNumberAvailability($phone);
    return $response->write(validationResponse($validate));
});

// Registration
$app->get("/user/register", function($request, $response, $args) {
    return $response->write(User::register());
});

// Run app
$app->run();
