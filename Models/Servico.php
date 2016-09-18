<?php

namespace Models;

final class Servico {
    
    public $id;
    public $descricao;
    
    /**
     * @return \Models\Servico
     */
    public static function Create($descricao, $id = null){
        $s = new Servico();
        $s->id = $id;
        $s->descricao = $descricao;
        return $s;
    }
    
}
