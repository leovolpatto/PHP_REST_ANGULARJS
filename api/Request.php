<?php

namespace api;

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
     * @return \api\Request
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
