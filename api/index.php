<?php

require 'vendor/autoload.php';
//Load phpActiveRecord
require 'php-activerecord/ActiveRecord.php';
//Load config class
require 'config.php';

// Create and configure Slim app
$app = new \Slim\App;

ActiveRecord\Config::initialize(function($cfg) {
    $config =  new Config;
    $dbConfig = $config->database;
    $connectionString = 'mysql://'.$dbConfig["user"].':'.$dbConfig['pass'].'@'.$dbConfig['host'].'/'.$dbConfig['database'];
    $cfg->set_model_directory('models');
    $cfg->set_connections(array(
        'development' => $connectionString));
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

//User login
$app->get("/user/login", function($request, $response, $args) {
    $answer = [];
    $login = User::login();
    if($login === false) {
        $answer['status'] = 'error';
    } else {
        $answer['status'] = 'success';
        $answer['session_id'] = $login;
    }
    return $response->write(json_encode($answer));
});

//Logged check
$app->get("/user/logged", function($request, $response, $args) {
    $session_id = filter_input(INPUT_GET, "session_id", FILTER_UNSAFE_RAW);
    $session = Session::find_by_id($session_id);
    return jsonRespond([
        "logged"  => ($session ? $session->id : false)
    ], $response);
});

//Get userdata from session
$app->get("/user/getdata", function($request, $response, $args){
    $sessionId = filter_input(INPUT_GET, "session_id", FILTER_UNSAFE_RAW);
    $data = Session::get_user_data($sessionId);
    if($data) {
        return jsonRespond([
            "status" => "success",
            "data" => $data
        ], $response);
    } else {
        return jsonRespond([
            "status" => "error"
        ], $response);
    }
});

// Run app
$app->run();
