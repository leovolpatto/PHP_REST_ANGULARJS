<?php

class Autoloader {

    public static $APP_NAME = 'php-rest-angularjs';
    
    public function __construct() {
        spl_autoload_register(array($this, 'loader'));
    }
    
    private function loader($className) {
        if (class_exists($className)) {
            return;
        }
        
        $file = $this->getClassFilePath($className);

        if (!file_exists($file)) {
            die("classe nao encontrada");
        }

        require_once $file;
    }
    
    private function getClassFilePath($className){
        $root = $_SERVER['DOCUMENT_ROOT'] . '/' . self::$APP_NAME;
        $file = $root . "/" . $className . '.php';
        $cfile = str_replace("\\", "/", $file);
        return $cfile;
    }
}

$autoloader = new Autoloader();

?>