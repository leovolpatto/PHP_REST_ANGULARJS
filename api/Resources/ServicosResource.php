<?php

namespace api\Resources;

final class ServicosResource extends Resource{
    
    private function definirResultado($statusCode, $conteudo){
        switch ($statusCode){
            case 200:
                $this->response = \api\Responses\JsonResponse::CreateOkResponse($conteudo);
                break;
            case 400:
                $this->response = \api\Responses\JsonResponse::CreateNotFoundResponse($conteudo);
                break;
            default:
                $this->response = \api\Responses\JsonResponse::CreateServerInternalErrorResponse($conteudo);
        }
        
        /**
         * Implementar outros status code caso necessario
         */
    }
    
    /**
     * @return \Models\Servico
     */
    private function criarServicoDeRequest(){        
        $jsonEnviado = $this->request->payload;
        $obj = json_decode($jsonEnviado);
        
        $id = isset($obj->id) ? $obj->id : null;
        
        $s = \Models\Servico::Create($obj->descricao, $id);
        return $s;
    }
    
    /**
     * lista um servico
     */
    public function getServico($parametroURL){
        $id = $parametroURL['id'];
        $repository = new \Repository\ServicoRepository();
        $resultado = $repository->listarServico($id);
        if($resultado == null){
            $this->definirResultado(400, "Servico nao encontrado");
        }else{
            $this->definirResultado(200, $resultado);
        }
    }
    
    /**
     * lista todos os servico
     */
    public function getServicos(){
        $repository = new \Repository\ServicoRepository();
        $resultado = $repository->listarTodos();
        $this->definirResultado(200, $resultado);
    }
    
    /**
     * Atualiza um servico
     */
    public function putServico(){
        $repository = new \Repository\ServicoRepository();
        $servico = $this->criarServicoDeRequest();
        
        if(empty($servico->id)){
            $this->definirResultado(400, "id, necessario para atualizar, nao foi informado");
        }
        
        if($repository->atualizarServico($servico)){
            $this->definirResultado(200, "OK");
        }
        else{
            $this->definirResultado(500, "Erro");
        }
    }
    
    /**
     * Inclui um servico
     */
    public function postServico(){
        $repository = new \Repository\ServicoRepository();
        $servico = $this->criarServicoDeRequest();
        
        $resultado = $repository->inserirServico($servico);
        if($resultado != null){
            $this->definirResultado(200, $servico);
        }
        else{
            $this->definirResultado(500, "Erro");
        }        
    }
    
    /**
     * Exclui o um servico
     */
    public function deleteServico($parametroURL){
        $id = $parametroURL['id'];
        $repository = new \Repository\ServicoRepository();
        
        if($repository->excluirServico($id)){
            $this->definirResultado(200, "OK");            
        }else{
            $this->definirResultado(500, "ERRO");
        }        
    }
    
}