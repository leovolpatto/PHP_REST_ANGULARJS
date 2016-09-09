<?php

namespace api;

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
        
        $route = $this->getRoute($request);
        
        var_dump($route);
    }
    
    /**
     * @param \api\Request $request
     * @return RouteDefinition Description
     */
    private function getRoute(Request $request){
        $route = null;        
        foreach($this->routeDefinitions as $route){
            if($request->method != $route->http_method){
                continue;
            }
            
            $route = $this->findRoute($route, $request);
            if($route != null){
                break;
            }
        }   
        
        return $route;
    }
    
    /**
     * @param \api\RouteDefinition $def
     * @param \api\Request $request
     * @return \api\RouteDefinition
     */
    private function findRoute(RouteDefinition $def, \api\Request $request){
        $parts = explode("/",$def->url);
        $urlParts = explode("/",$request->URI);
        
        $match = false;
        for($i = 0; $i < count($parts); $i++){
            for($r = $i; $r < count($urlParts); $r++){
                
                $urlRota = $parts[$i];
                $urlRequesst = $urlParts[$r];
                
                if($this->isParameter($urlRota)){
                    $match = true;
                }else{
                    $match = $urlRota == $urlRequesst;
                }
            }
        }
        
        return $def;
    }
    
    /**
     * @param type $string
     * @return boolean
     */
    private function isParameter($string){
        if (strpos($string, ':') !== false) {
            return true;
        }
        
        return false;
    }
}

class RouteDefinition{
    public $http_method;
    public $url;
    public $handler;
}
