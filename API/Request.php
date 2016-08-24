<?php

namespace API;

final class Request {
    
    public $method;
    public $URI;
    /**
     * @var array
     */
    public $headers;
    public $payload;
    
    private function __construct() {
        
    }
    
    /**
     * @return \API\Request
     */
    public static function Create(){
        $r = new Request();
        $r->URI = $_REQUEST['parameters'];
        $r->method = $_SERVER['REQUEST_METHOD'];
        $r->headers = apache_request_headers();
        $r->payload = file_get_contents("php://input");
        return $r;
    }
}
