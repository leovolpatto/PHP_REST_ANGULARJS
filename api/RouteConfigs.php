<?php

namespace api;

final class RouteConfigs {
    
    /**
     * @var Router
     */
    private $router;
    
    /**
     * @return \api\Router
     */
    public function buildRouter(){
        $this->router = new Router();
        
        $this->setPessoaRoutes();
        
        return $this->router;
    }
    
    private function setPessoaRoutes(){
        $this->router
                ->addRoute(Router::HTTP_METHOD_GET, "pessoas", new Resources\PessoasResource(), "listarPessoas")
                ->addRoute(Router::HTTP_METHOD_GET, "pessoas/:id", new Resources\PessoasResource(), "listarPessoa")
                ->addRoute(Router::HTTP_METHOD_POST, "pessoas", new Resources\PessoasResource(), "incluirPessoa")
                ->addRoute(Router::HTTP_METHOD_PUT, "pessoas", new Resources\PessoasResource(), "alterarPessoa")
                ->addRoute(Router::HTTP_METHOD_DELETE, "pessoas/:id", new Resources\PessoasResource(), "excluirPessoa");
    }
    
}
