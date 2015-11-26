<?php

/*
  Reppier management system
  Design and code - M82.eu
 * 
 * Model class for managing DB tables
 */

class Model {

    private $connection;
    public $tableName;
    private $tableRows = array();
    private $pk;
    private $isNew = true;

    public function __construct() {
        $this->connection = new DatabaseConnection();
        $this->checkTableName();
        $this->setVariablesFromTableSchema();
        $this->getPkRow();
    }

    private function checkTableName() {
        $check = mysql_query("SHOW TABLES LIKE '$this->tableName'") or die(mysql_error());
        if (mysql_num_rows($check) != 1) {
            die("Wrong model name: No '$this->tableName' table in DB");
        }
        return true;
    }

    private function setVariablesFromTableSchema() {
        $query = mysql_query("DESCRIBE $this->tableName");
        while ($row = mysql_fetch_array($query)) {
            array_push($this->tableRows, $row['Field']);
            $this->$row['Field'] = null;
        }
    }

    private function getPkRow() {
        $query = mysql_query("SHOW KEYS FROM $this->tableName WHERE Key_name = 'PRIMARY'") or die(mysql_error());
        if (mysql_num_rows($query) != 1) {
            die("Can't get PK for $this->tableName");
        }
        $result = mysql_fetch_array($query);
        $this->pk = $result['Column_name'];
    }

    public function setAttributes($attrs) {
        foreach ($attrs as $attr => $val) {
            $this->$attr = $val;
        }
    }

    public function getByPk($pk) {
        $query = mysql_query("SELECT * FROM $this->tableName WHERE $this->pk = '$pk'") or die(mysql_error());
        if (mysql_num_rows($query) != 1) {
            return false;
        }
        $fetched = mysql_fetch_array($query);
        foreach ($this->tableRows as $row) {
            $this->$row = $fetched[$row];
        }
        $this->isNew = false;
    }

    public function save() {
        if ($this->isNew) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    private function insert() {
        if (!$this->isNew) {
            return false;
        }
        $queryString = $this->formatInsertQueryString();
        mysql_query($queryString) or die(mysql_error());
        $this->setLastInsertedId();
    }

    private function formatInsertQueryString() {
        $rows = $this->getInsertRows();
        if (!$rows) {
            return false;
        }
        $values = $this->getInsertValues();
        if (!$values) {
            return false;
        }
        $queryString = "INSERT INTO $this->tableName ($rows) VALUES ($values)";
        return $queryString;
    }

    private function getInsertRows() {
        //Format insert fields
        $urows = "";
        foreach ($this->tableRows as $row) {
            if ($row == $this->pk) {
                continue;
            }
            $urows = $urows . $row . ", ";
        }
        //Delete ", " from the end
        $rows = substr($urows, 0, strlen($urows) - 2);

        return $rows;
    }

    private function getInsertValues() {
        //Format values to insert
        $uvalues = "";
        foreach ($this->tableRows as $row) {
            if ($row == $this->pk) {
                continue;
            }
            $uvalues = $uvalues . "'" . mysql_real_escape_string($this->$row) . "', ";
        }
        //Delete ", " from the end
        $values = substr($uvalues, 0, strlen($uvalues) - 2);

        return $values;
    }

    private function setLastInsertedId() {
        $insertedId = mysql_insert_id();
        if ($insertedId == 0) {
            return false;
        }
        $pkrow = $this->pk;
        $this->$pkrow = $insertedId;
        $this->isNew = true;
    }

    private function update() {
        $queryString = $this->formatUpdateQueryString();
        mysql_query($queryString) or die(mysql_error());
        return true;
    }

    private function formatUpdateQueryString() {
        $values = $this->formatUpdateValues();
        $pkrow = $this->pk;
        $queryString = "UPDATE $this->tableName SET $values WHERE $pkrow = '" . $this->$pkrow . "'";
        return $queryString;
    }
    
    private function formatUpdateValues() {
        $uvalues = "";
        foreach ($this->tableRows as $row) {
            $uvalues = $uvalues . $row . " = '" . mysql_real_escape_string($this->$row) . "', ";
        }
        $values = substr($uvalues, 0, strlen($uvalues) - 2);
        
        return $values;
    }
    
    public function rules() {
        return array();
    }
    
    public function validate() {
        
    }
    
    private function getAttributesArray() {
        
    }

}

//Load all models
$classesDir = scandir("./models");

foreach ($classesDir as $file) {
    $length = strlen($file);
    $substring = substr($file, $length - 4, 4);
    if ($substring == ".php") {
        include_once("./models/" . $file);
    }
}

