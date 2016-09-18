<?php

namespace Models;

final class Historico {
    
    public $id;
    public $idPessoa;
    public $idServico;
    public $descricao;
    public $valor;
    /**
     * @var \DateTime
     */
    public $data;
    
    /**
     * @param int $idPessoa
     * @param int $idServico
     * @param string $descricao
     * @param float $valor
     * @param \DateTime $data
     * @param int $id
     * @return \Models\Historico
     */
    public static function Create($idPessoa, $idServico, $descricao, $valor, $data, $id = null){
        $h = new Historico();
        $h->id = $id;
        $h->idPessoa = $idPessoa;
        $h->idServico = $idServico;
        $h->descricao = $descricao;
        $h->valor = $valor;
        $h->data = $data;
        return $h;
    }
    
}
