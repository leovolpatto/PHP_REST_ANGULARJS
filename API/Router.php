<?php

namespace API;

final class Router {
    
    const HTTP_METHOD_POST = "POST";
    const HTTP_METHOD_GET = "GET";
    const HTTP_METHOD_DELETE = "DELETE";
    const HTTP_METHOD_PUT = "PUT";

        /**
     * @param string $http_method
     * @param string $url
     * @param Router $handler
     */
    public function addRoute($http_method, $url, $handler){
        return $this;
    }
            
}
