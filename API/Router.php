<?php

namespace API;

final class Router {
    
    const HTTP_METHOD_POST = "POST";
    const HTTP_METHOD_GET = "GET";
    const HTTP_METHOD_DELETE = "DELETE";
    const HTTP_METHOD_PUT = "PUT";

    /**
     * @var RouteDefinition[]
     */
    private $routeDefinitions;
    
    public function __construct() {
        $this->routeDefinitions = array();
    }
    
    /**
     * @param string $http_method
     * @param string $url
     * @param Router $handler
     */
    public function addRoute($http_method, $url, $handler){
        $def = new RouteDefinition();
        $def->handler = $handler;
        $def->http_method = $http_method;
        $def->url = $url;
        
        array_push($this->routeDefinitions, $def);
        
        return $this;
    }
    
    public function routeRequest(){
        $request = Request::Create();
        
        foreach($this->routeDefinitions as $route){
            if($request->method != $route->http_method){
                continue;
            }
            
            $this->findRoute($route, $request);
        }
    }
    
    private function findRoute(RouteDefinition $def, \API\Request $request){
        $parts = explode("/",$def->url);
        var_dump($parts);
    }
            
}

class RouteDefinition{
    public $http_method;
    public $url;
    public $handler;
}
