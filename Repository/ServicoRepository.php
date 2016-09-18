<?php

namespace Repository;

final class ServicoRepository extends Repository{
    
    /**
     * @return \Models\Servico[]
     */
    public function listarTodos(){
        $qry = "SELECT * FROM servicos;";
        $resultado = \Utils\Data\MySQL::Instance()->select($qry);
        if(!$resultado->isSuccess() || count($resultado->getResultArray()) == 0){
            return array();
        }
        
        $servicosDB = $resultado->getResultArray();
        $servicos = array();
        foreach ($servicosDB as $s){
            $sr = \Models\Servico::Create($s['descricao'], $s['id']);
            array_push($servicos, $sr);
        }
        
        return $servicos;
    }
    
    /**
     * @return \Models\Servico
     */
    public function listarServico($id){
        $qry = "SELECT * FROM servicos WHERE id = '$id';";
        $resultado = \Utils\Data\MySQL::Instance()->select($qry);
        if(!$resultado->isSuccess() || count($resultado->getResultArray()) == 0){
            return null;
        }
        
        $servicosDB = $resultado->getResultArray();
        $s = $servicosDB[0];
        $sr = \Models\Servico::Create($s['descricao'], $s['id']);
        return $sr;
    }
    
    /**
     * @param \Models\Servico $servico
     * @return \Models\Servico
     */
    public function inserirServico(\Models\Servico $servico){
        $qry = "INSERT INTO servicos (descricao) VALUES ('{$servico->descricao}');";
        $resultado = \Utils\Data\MySQL::Instance()->execute($qry);
        if(!$resultado->isSuccess()){
            return null;
        }
        
        $idInserido = $resultado->getInsertID();
        $servico->id = $idInserido;
        return $servico;
    }
    
    /**
     * @param \Models\Servico $servico
     * @return boolean
     */
    public function atualizarServico(\Models\Servico $servico){
        $qry = "UPDATE servicos SET descricao = '{$servico->descricao}' WHERE id = '{$servico->id}';";
        $resultado = \Utils\Data\MySQL::Instance()->execute($qry);
        return $resultado->isSuccess();
    }
    
    /**
     * @param int $id
     * @return boolean
     */
    public function excluirServico($id){
        $qry = "DELETE FROM servicos WHERE id = '{$id}';";
        $resultado = \Utils\Data\MySQL::Instance()->execute($qry);
        return $resultado->isSuccess();
    }    
}