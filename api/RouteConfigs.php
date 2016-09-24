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
        $this->setServicoRoutes();
        
        return $this->router;
    }
    
    private function setPessoaRoutes(){
        $this->router
                ->addRoute(Router::HTTP_METHOD_GET, "pessoas", new Resources\PessoasResource(), "listarPessoas")
                ->addRoute(Router::HTTP_METHOD_GET, "pessoas/:id", new Resources\PessoasResource(), "listarPessoa")
                ->addRoute(Router::HTTP_METHOD_POST, "pessoas", new Resources\PessoasResource(), "incluirPessoa")
                ->addRoute(Router::HTTP_METHOD_PUT, "pessoas", new Resources\PessoasResource(), "alterarPessoa")
                ->addRoute(Router::HTTP_METHOD_DELETE, "pessoas/:id", new Resources\PessoasResource(), "excluirPessoa");
        
        $this->router
                ->addRoute(Router::HTTP_METHOD_GET, "pessoas/:idPessoa/historicos", new Resources\HistoricosResource(), "listarTodosHistoricos")
                ->addRoute(Router::HTTP_METHOD_GET, "pessoas/:idPessoa/historicos/:idHistorico", new Resources\HistoricosResource(), "listarHistorico")
                ->addRoute(Router::HTTP_METHOD_POST, "pessoas/:idPessoa/historicos", new Resources\HistoricosResource(), "incluirHistorico")
                ->addRoute(Router::HTTP_METHOD_PUT, "pessoas/:idPessoa/historicos", new Resources\HistoricosResource(), "alterarHistorico")
                ->addRoute(Router::HTTP_METHOD_DELETE, "pessoas/:idPessoa/historicos/:idHistorico", new Resources\HistoricosResource(), "excluirHistorico");
    }
    
    private function setServicoRoutes(){
        $this->router
                ->addRoute(Router::HTTP_METHOD_GET, "servicos", new Resources\ServicosResource(), "getServicos")
                ->addRoute(Router::HTTP_METHOD_GET, "servicos/:id", new Resources\ServicosResource(), "getServico")
                ->addRoute(Router::HTTP_METHOD_POST, "servicos", new Resources\ServicosResource(), "postServico")
                ->addRoute(Router::HTTP_METHOD_PUT, "servicos", new Resources\ServicosResource(), "putServico")
                ->addRoute(Router::HTTP_METHOD_DELETE, "servicos/:id", new Resources\ServicosResource(), "deleteServico");
    }
    
}
