<?php

namespace api\Resources;

final class PessoasResource extends Resource{
    
    public function listarPessoa($pars){
        $t = new \Repository\PessoaRepository();
        $pessoas = $t->carregar($pars['id']);
        
        $this->response = \api\Responses\JsonResponse::CreateOkResponse($pessoas);
    }
    
    public function listarPessoas(){
        $t = new \Repository\PessoaRepository();
        $pessoas = $t->carregarTodas();
        
        $this->response = \api\Responses\JsonResponse::CreateOkResponse($pessoas);
    }
    
    public function alterarPessoa($pars){
        $p = $this->request->payload;
        $objs = json_decode($p);
    }
    
    public function incluirPessoa($pars){
        $p = $this->request->payload;
        $objs = json_decode($p);        
    }
    
    public function excluirPessoa(){
        
    }
    
}
