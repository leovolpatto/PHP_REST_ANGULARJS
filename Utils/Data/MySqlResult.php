<?php

namespace Utils\Data;

final class MySqlResult {
    
    /**
     * @var boolean
     */
    private $success;
    
    /**
     * @var array
     */
    private $result;
    
    private $msg;
    
    private $insertID;
    
    public function __construct() {
        $this->result = null;
        $this->success = false;
        $this->insertID = null;
    }
    
    /**
     * @return \Utils\Data\MySqlResult
     */
    public static function Create($success, $msg, $insertID){
        $r = new MySqlResult();
        $r->success = $success;
        $r->insertID = $insertID;
        $r->msg = $msg;
        return $r;
    }
    
    /**
     * @return \Utils\Data\MySqlResult
     */
    public static function CreateSelect($success, $msg, $result){
        $r = new MySqlResult();
        $r->success = $success;
        $r->result = $result;
        $r->msg = $msg;
        return $r;
    }

    /**
     * @return boolean
     */
    public function isSuccess(){
        return $this->success;
    }
    
    /**
     * @return array
     */
    public function getResultArray(){
        return $this->result;
    }
    
}
