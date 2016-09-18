<?php

namespace Repository;

use Models\Pessoa;

final class PessoaRepository extends Repository{
    
    /**
     * @param Pessoa $pessoa
     * @return boolean
     */
    public function salvar(Pessoa $pessoa){
        if($this->carregar($pessoa->id) == null){//pessoa realmente existe?
            return false;
        }
        
        $qry = "UPDATE pessoas SET nome='{$pessoa->nome}', sobrenome='{$pessoa->sobrenome}', idade='{$pessoa->idade}',ativa='{$pessoa->ativa}' WHERE id = '{$pessoa->id}';";
        $resultado = \Utils\Data\MySQL::Instance()->execute($qry);
        return $resultado->isSuccess();
    }
    
    /**
     * Salva uma pessoa (na tabela com auto-increment e, caso sucesso, retorna o id gerado, senão, null
     * @param Pessoa $pessoa
     * @return int
     */
    public function incluirNovaPessoa(Pessoa $pessoa){        
        $qry = "INSERT INTO pessoas (nome, sobrenome, idade, ativa) VALUES ('{$pessoa->nome}', '{$pessoa->sobrenome}', '{$pessoa->idade}', '{$pessoa->ativa}');";
        $resultado = \Utils\Data\MySQL::Instance()->execute($qry);
        $idInseridoPeloMySQL = $resultado->getInsertID();
        if(!$resultado->isSuccess()){
            return null;
        }
        
        return $idInseridoPeloMySQL;
    }

    /**
     * @param int $id
     * @return boolean
     */
    public function excluir($id){
        $qry = "DELETE from pessoas WHERE id = '$id';";
        $resultado = \Utils\Data\MySQL::Instance()->execute($qry);
        return $resultado->isSuccess();
    }
    
    /**
     * @param int $id
     * @return Pessoa
     */
    public function carregar($id){
        $result = \Utils\Data\MySQL::Instance()->select("SELECT * FROM pessoas WHERE id = $id");
        if(!$result->isSuccess() || count($result->getResultArray()) == 0){
            return null;
        }
        
        $pessoasBD = $result->getResultArray();
        $p = $pessoasBD[0];
        
        $ps = Pessoa::Create($p['nome'], $p['sobrenome'], $p['idade'], $p['ativa'], $p['id']);
        return $ps;
    }
    
    /**
     * @return Pessoa[]
     */
    public function carregarTodas(){        
        $result = \Utils\Data\MySQL::Instance()->select("SELECT * FROM pessoas");
        if(!$result->isSuccess()){
            return array();
        }
        
        $pessoasBD = $result->getResultArray();
        $pessoas = array();
        foreach($pessoasBD as $p){
            $ps = Pessoa::Create($p['nome'], $p['sobrenome'], $p['idade'], $p['ativa'], $p['id']);
            array_push($pessoas, $ps);
        }
        
        return $pessoas;
    }
}