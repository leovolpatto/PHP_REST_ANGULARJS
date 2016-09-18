<?php

namespace api\Resources;

final class PessoasResource extends Resource{
    
    public function listarPessoa($pars){
        $t = new \Repository\PessoaRepository();
        $pessoas = $t->carregar($pars['id']);
        
        if($pessoas == null){
            $this->response = \api\Responses\JsonResponse::CreateNotFoundResponse("Pessoa nao encontrada");
        }
        else{
            $this->response = \api\Responses\JsonResponse::CreateOkResponse($pessoas);
        }
    }
    
    public function listarPessoas(){
        $t = new \Repository\PessoaRepository();
        $pessoas = $t->carregarTodas();
        
        $this->response = \api\Responses\JsonResponse::CreateOkResponse($pessoas);
    }
    
    public function alterarPessoa(){
        $p = $this->request->payload;
        $obj = json_decode($p);
        
        if(!isset($obj->id)){
            $this->response = \api\Responses\JsonResponse::CreateNotFoundResponse("O id da pessoa deve ser informado");
            return;
        }
        
        $pessoa = \Models\Pessoa::Create($obj->nome, $obj->sobrenome, $obj->idade, $obj->ativa, $obj->id);
        
        $repositorio = new \Repository\PessoaRepository();
        if($repositorio->salvar($pessoa)){
            $this->response = \api\Responses\JsonResponse::CreateOkResponse("OK");
        }
        else{
            $this->response = \api\Responses\JsonResponse::CreateNotFoundResponse("Pessoa nao encontrada");
        }        
    }
        
    public function incluirPessoa(){
        $p = $this->request->payload;
        $obj = json_decode($p);        
        
        $pessoa = \Models\Pessoa::Create($obj->nome, $obj->sobrenome, $obj->idade, $obj->ativa);        
        $repositorio = new \Repository\PessoaRepository();
        $resultado = $repositorio->incluirNovaPessoa($pessoa);
        if($resultado != null){
            $pessoa->id = $resultado; //atribui o ID gerado na pessoa e a retorna...
            $this->response = \api\Responses\JsonResponse::CreateOkResponse($pessoa);
        }
        else{
            $this->response = \api\Responses\JsonResponse::CreateServerInternalErrorResponse("Erro");
        }
    }
    
    public function excluirPessoa($parametros){
        if(!isset($parametros['id'])){
            $this->response = \api\Responses\JsonResponse::CreateNotFoundResponse("id nao informado");
            return;
        }
        
        $id = $parametros['id'];
        $repositorio = new \Repository\PessoaRepository();
        if($repositorio->excluir($id)){
            $this->response = \api\Responses\JsonResponse::CreateOkResponse("OK");
        }
        else{
            $this->response = \api\Responses\JsonResponse::CreateServerInternalErrorResponse("Erro");
        }
    }
}