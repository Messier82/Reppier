<?php

class Config {

    private $configFile = "config.json";

    public function __construct() {
        $this->loadConfigFile();
    }

    private function loadConfigFile() {
        $configFile = file_get_contents($this->configFile);
        if (!$configFile) {
            return false;
        }
        $parsedConfig = json_decode($configFile, true);
        if (!$parsedConfig) {
            return false;
        }
        // Checking for all important config values
        // Checking for correct database config
        $dbConfig = $parsedConfig['database'];
        if (!$dbConfig) {
            return false;
        }
        if (!$dbConfig['host']) {
            return false;
        }
        if (!$dbConfig['user']) {
            return false;
        }
        if (!$dbConfig['pass'] && $dbConfig['pass'] != "") {
            return false;
        }
        if (!$dbConfig['database']) {
            return false;
        }
        $this->setParameters($parsedConfig);
        return true;
    }
    
    private function setParameters($paramsToSet) {
        foreach ($paramsToSet as $param => $value) {
            $this->$param = $value;
        }
    }

}
