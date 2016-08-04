<?php

namespace Utils\Data;

final class MySQL {

    /**
     * @var \mysqli
     */
    private $connection;
    private static $singleton;

    public function __construct() {
        $this->connection = new \mysqli(
                "localhost", 
                "root", 
                "spring", 
                "php_rest", 
                3306);
        $this->connection->set_charset("utf8");
    }

    /**
     * @return MySQL
     */
    public static function Instance() {
        if (!isset(MySQL::$singleton) || MySQL::$singleton == null)
            MySQL::$singleton = new MySQL();

        return MySQL::$singleton;
    }

    public function escapeString($unescapedString) {
        return $this->connection->real_escape_string($unescapedString);
    }

    /**
     * @param string $qry
     * @param string $className
     * @return MySqlResult
     */
    public function selectObject($qry, $className) {
        $result = $this->connection->query($qry);

        if (!$result) {
            if (isset($result) && $result instanceof \mysqli_result) {
                $result->free();
            }
            
            return MySqlResult::Create(false, $this->connection->error, null);
        }

        if ($result instanceof \mysqli_result) {
            $resultArray = $this->buildObject($result, $className);
            $result->free();
            return MySqlResult::CreateSelect(true, $this->connection->error, $resultArray);
        }

        return MySqlResult::CreateSelect($result, $this->connection->error, $result);
    }
    
    private function buildObject(\mysqli_result $result, $className){
        $resultArray = array();
        while (($x = $result->fetch_object($className)) != null) {
            array_push($resultArray, $x);
        }
        
        return $resultArray;
    }
    
    /**
     * @param string $qry
     * @return MySqlResult
     */
    public function select($qry) {
        $result = $this->connection->query($qry);

        if (!$result) {
            if (isset($result) && $result instanceof \mysqli_result) {
                $result->free();
            }

            return MySqlResult::CreateSelect(false, $this->connection->error, null);
        }

        if ($result instanceof \mysqli_result) {
            $resultArray = $this->BuildArray($result, MYSQLI_ASSOC);
            $result->free();
            return MySqlResult::CreateSelect(true, $this->connection->error, $resultArray);
        }

        if (is_bool($result)){
            return MySqlResult::CreateSelect($result, $this->connection->error, $result);
        }

        return MySqlResult::CreateSelect(false, $this->connection->error, null);
    }

    private function BuildArray(\mysqli_result $result, $resultType) {
        $resultArray = array();

        while (($x = $result->fetch_array($resultType)) != null) {
            array_push($resultArray, $x);
        }
        return $resultArray;
    }


    /**
     * @param type $qry
     * @return MySqlResult
     */
    public function execute($qry) {
        $dbResult = $this->connection->query($qry);

        if (is_bool($dbResult) && $dbResult === true) {
            $insertID = $this->connection->insert_id;
            return MySqlResult::Create(true, "", $insertID);
        } else if (is_object($dbResult)) {
            if ($dbResult instanceof \mysqli_result) {
                $insertID = $this->connection->insert_id;
                return MySqlResult::Create(true, "", $insertID);
            }
        }

        return MySqlResult::Create(false, "", null);
    }
}