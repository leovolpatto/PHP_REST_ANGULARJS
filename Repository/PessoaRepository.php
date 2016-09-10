<?php

namespace Repository;

use Models\Pessoa;

final class PessoaRepository extends Repository{
    
    /**
     * @param Pessoa $pessoa
     * @return boolean
     */
    public function salvar(Pessoa $pessoa){
        return true;
    }

    /**
     * @param Pessoa $pessoa
     * @return boolean
     */
    public function excluir(Pessoa $pessoa){
        return true;
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

    protected function getTableName() {
        return "pessoas";
    }

}
