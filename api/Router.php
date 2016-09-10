<?php

namespace api;

use api\Responses\IRestResponse;
use api\Responses\JsonResponse;

/**
 * @author Leonardo Volpatto <leovolpatto@gmail.com>
 */
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
     * @param Resources\IResource $handler Instancia do resource a ser chamado
     * @param string $handlerMethod Nome do metodo a ser chamado no resource
     */
    public function addRoute($http_method, $url, $handler, $handlerMethod){
        $def = new RouteDefinition();
        $def->handler = $handler;
        $def->http_method = $http_method;
        $def->url = $url;
        $def->handlerMethod = $handlerMethod;
        
        array_push($this->routeDefinitions, $def);
        
        return $this;
    }
    
    public function routeRequest(){
        $request = Request::Create();
        
        $route = $this->getRoute($request);    
        
        if($route == null){
            $response = JsonResponse::CreateNotFoundResponse("Recurso nao encontrado");
            $this->sendResponse($response);
            die;
        }
        
        $response = $this->invokeResource($route, $request);
        $this->sendResponse($response);
    }
    
    /**
     * @param \api\RouteDefinition $routeDefinition
     * @return IRestResponse
     */
    private function invokeResource(RouteDefinition $routeDefinition, Request $request){
        $resource = $routeDefinition->handler;
        $resource->setRequest($request);
        $method = $routeDefinition->handlerMethod;
        
        $reflectionMethod = new \ReflectionMethod($resource, $method); //usamos reflection para invokar o metodo que irá tratar nosso request
        $reflectionMethod->invoke($resource, $routeDefinition->parameters);
        return $resource->getResponse();
        
    }
    
    private function sendResponse(IRestResponse $response){
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type: {$response->getContentType()}; charset={$response->getCharset()}");
        header("HTTP/1.1 {$response->getStatusCode()} {$response->getMessage()}");
        
        echo $response->getContent();
    }
    
    /**
     * @param \api\Request $request
     * @return RouteDefinition Description
     */
    private function getRoute(Request $request){
        $matchedRoute = null;        
        foreach($this->routeDefinitions as $route){
            if($request->method != $route->http_method){
                continue;
            }
            
            $matchedRoute = $this->findRoute($route, $request);
            if($matchedRoute != null){
                break;
            }
        }   
        
        return $matchedRoute;
    }
    
    /**
     * @param \api\RouteDefinition $def
     * @param \api\Request $request
     * @return \api\RouteDefinition
     */
    private function findRoute(RouteDefinition $def, \api\Request $request){
        $parts = explode("/",$def->url);
        $urlParts = explode("/",$request->URI);
        
        if(count($parts) != count($urlParts)){
            return null;
        }
        
        for($i = 0; $i < count($parts); $i++){
            $urlRota = $parts[$i];
            $urlRequesst = $urlParts[$i];
            
            if($urlRota != $urlRequesst){
                if(!$this->isParameter($urlRota)){ //se nao for igual e também não for um parametro, sai.
                    return null;
                }else{
                    $def->addParameter($urlRota, $urlRequesst);
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
    /**
     * Instancia do Resource
     * @var Resources\IResource
     */
    public $handler;
    /**
     * Nome do método a ser chamado
     * @var string
     */
    public $handlerMethod;
    /**
     * Parametros da url
     * @var array
     */
    public $parameters = array();
    
    public function addParameter($key, $value){
        $key = str_replace(":", "", $key);//removemos o : do parametro
        $this->parameters[$key] = $value;
    }
}
