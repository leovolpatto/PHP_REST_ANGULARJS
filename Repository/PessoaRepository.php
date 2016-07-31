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
        return new Pessoa();
    }

    protected function getTableName() {
        return "pessoas";
    }

}
