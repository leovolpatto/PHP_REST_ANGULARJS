<?php

namespace api\Resources;

final class HistoricosResource extends Resource {
    
    /**
     * @param int $id
     * @return boolean
     */
    private function pessoaExiste($id){
        $p = new \Repository\PessoaRepository();
        return $p->carregar($id) != null;
    }
    
    private function verificarPessoa($id){
        if(!$this->pessoaExiste($id)){
            $this->response->CreateNotFoundResponse("Pessoa $id nao existe");
            return false;
        }
        
        return true;
    }
    
    /**
     * @return \Models\Historico
     */
    private function criarHistoricoDoRequest(){
        $obj = json_decode($this->request->payload);
        
        return \Models\Historico::Create($obj->idPessoa, $obj->idServico, $obj->descricao, $obj->valor, $obj->data, $obj->id);
    }
    
    public function listarHistorico($par){
        if(!$this->verificarPessoa($par['idPessoa'])){
            return;
        }
        
        $id = $par["idHistorico"];
        $hist = new \Repository\HistoricoRepository();
        $historico = $hist->listarHistorico($id);
        
        if($historico == null){
            $this->response = \api\Responses\JsonResponse::CreateNotFoundResponse("$id nao encontrado");
        }else{
            $this->response = \api\Responses\JsonResponse::CreateOkResponse($historico);
        }
    }
    
    public function listarTodosHistoricos($par){
        if(!$this->verificarPessoa($par['idPessoa'])){
            return;
        }
        
        $hist = new \Repository\HistoricoRepository();
        $historicos = $hist->listarTodosHistoricosDaPessoa($par["idPessoa"]);
        
        $this->response = \api\Responses\JsonResponse::CreateOkResponse($historicos);
    }
    
    public function incluirHistorico($par){
        if(!$this->verificarPessoa($par['idPessoa'])){
            return;
        }
        
        $historico = $this->criarHistoricoDoRequest();
        $rep = new \Repository\HistoricoRepository();
        if($rep->incluirHistorico($historico) == null){
            $this->response = \api\Responses\JsonResponse::CreateServerInternalErrorResponse("Erro");
        }else{
            $this->response = \api\Responses\JsonResponse::CreateOkResponse($historico);
        }
    }
    
    public function alterarHistorico($par){
        if(!$this->verificarPessoa($par['idPessoa'])){
            return;
        }

        $historico = $this->criarHistoricoDoRequest();
        $rep = new \Repository\HistoricoRepository();
        if($rep->alterarHistorico($historico)){
            $this->response = \api\Responses\JsonResponse::CreateOkResponse("OK");
        }else{
            $this->response = \api\Responses\JsonResponse::CreateServerInternalErrorResponse("Erro");
        }
    }
    
    public function excluirHistorico($par){
        if(!$this->verificarPessoa($par['idPessoa'])){
            return;
        }

        $rep = new \Repository\HistoricoRepository();
        if($rep->excluirHistorico($par["idHistorico"])){
            $this->response = \api\Responses\JsonResponse::CreateOkResponse("OK");
        }else{
            $this->response = \api\Responses\JsonResponse::CreateServerInternalErrorResponse("Erro");
        }
    }
    
}
