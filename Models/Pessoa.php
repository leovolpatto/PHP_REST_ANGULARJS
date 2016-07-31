<?php

namespace Models;

final class Pessoa {
    
    private $id;
    private $nome;
    private $sobrenome;
    private $idade;
    private $ativa;
    
    public static function Create($nome, $sobrenome, $idade, $ativa, $id = null){
        $pessoa = new Pessoa();
        $pessoa->setAtiva($ativa);
        $pessoa->setId($id);
        $pessoa->setIdade($idade);
        $pessoa->setNome($nome);
        $pessoa->setSobrenome($sobrenome);
        return $pessoa;
    }
    
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }
    
    public function getNome(){
        return $this->nome;
    }
    
    public function getSobrenome(){
        return $this->sobrenome;
    }
    
    /**
     * @return int
     */
    public function getIdade(){
        return $this->idade;
    }
    
    /**
     * @return boolean
     */
    public function getAtiva(){
        return $this->ativa;
    }
    
    /**
     * @param int $id
     */    
    public function setId($id){
        $this->id = $id;
    }
    
    /**
     * @param string $nome
     */    
    public function setNome($nome){
        $this->nome = $nome;
    }
    
    /**
     * @param string $sobreNome
     */
    public function setSobrenome($sobreNome){
        $this->sobrenome = $sobreNome;
    }
    
    /**
     * @param int $idade
     */
    public function setIdade($idade){
        $this->idade = $idade;
    }
    
    /**
     * @param boolean $ativa
     */
    public function setAtiva($ativa){
        $this->ativa = $ativa;
    }
    
}
