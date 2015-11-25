<?php

//Reppier management system
//Design and code - M82.eu
//
//Class for managing connection to DB

class DatabaseConnection {

    private $host = "";
    private $user = "";
    private $pass = "";
    private $database = "";
    private $configFile = "./config.json";
    
    public function __construct() {
        $connect = $this->connect(); 
       if(!$connect) {
            return false;
        }
        return $this;
    }
    
    private function connect() {
        $configLoading = $this->loadParametersFromJSONFile($this->configFile);
        if(!$configLoading) {
            return false;
        }
        $connection = mysql_connect($this->host, $this->user, $this->pass) or die(mysql_error());
        if(!$connection) {
            return false;
        }
        $database = mysql_select_db($this->database, $connection) or die(mysql_error());
        if(!$database) {
            return false;
        }
        return true;
    }

    private function loadParametersFromJSONFile($file) {
        $configFile = file_get_contents($file);
        if(!$configFile) {
            return false;
        }
        $parsedConfig = json_decode($configFile, true);
        if(!$parsedConfig) {
            return false;
        }
        $config  = $parsedConfig['database'];
        if(!$config) {
            return false;
        }
        if(!$config['host']) { return false; }
        if(!$config['user']) { return false; }
        if(!$config['pass'] && $config['pass'] != "") { return false; }
        if(!$config['database']) { return false; }
        $this->setParameters($config['host'], $config['user'], $config['pass'], $config['database']);
        return true;
    }
    
    public function setParameters($host = null, $user = null, $pass = null, $database = null) {
        if ($host) {
            $this->host = $host;
        }
        if ($user) {
            $this->user = $user;
        }
        if($pass) {
            $this->pass = $pass;
        }
        if($database) {
            $this->database = $database;
        }
    }

}
