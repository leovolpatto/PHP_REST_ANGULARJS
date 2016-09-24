<?php

namespace Repository;

final class HistoricoRepository extends Repository {
    
    /**
     * @param int $id
     * @return \Models\Historico
     */
    public function listarHistorico($id){
        $resultado = \Utils\Data\MySQL::Instance()->select("SELECT * FROM historicos WHERE id = '$id'");
        if(!$resultado->isSuccess() || count($resultado->getResultArray()) == 0){
            return null;
        }
       
        $dados = $resultado->getResultArray();
        $historicoDB = $dados[0];
        
        $historico = \Models\Historico::Create(
                intval($historicoDB["idPessoa"]), 
                intval($historicoDB["idServico"]),
                $historicoDB["descricao"],
                floatval($historicoDB["valor"]),
                $historicoDB["data"], 
                intval($historicoDB["id"]));
        
        $servicoRep = new ServicoRepository();
        $historico->Servico = $servicoRep->listarServico($historico->idServico);
        
        return $historico;
    }
    
    /**
     * @param int $idPessoa
     * @return \Models\Historico[]
     */
    public function listarTodosHistoricosDaPessoa($idPessoa){
        $resultado = \Utils\Data\MySQL::Instance()->select("SELECT * FROM historicos WHERE idPessoa = '$idPessoa'");
        if(!$resultado->isSuccess() || count($resultado->getResultArray()) == 0){
            return array();
        }
       
        $dados = $resultado->getResultArray();
        $hists = array();
        
        $servicoRep = new ServicoRepository();
        
        foreach($dados as $historicoDB){
            $historico = \Models\Historico::Create(
                    intval($historicoDB["idPessoa"]), 
                    intval($historicoDB["idServico"]),
                    $historicoDB["descricao"],
                    floatval($historicoDB["valor"]),
                    $historicoDB["data"], 
                    intval($historicoDB["id"]));

            $historico->Servico = $servicoRep->listarServico($historico->idServico);                    
            array_push($hists, $historico);
        }
        
        return $hists;
    }
    
    /**
     * @param \Models\Historico $hist
     * @return \Models\Historico
     */
    public function incluirHistorico(\Models\Historico $hist){
        $qry = "INSERT INTO historicos (idPessoa, idServico, descricao, valor, data) VALUES ('{$hist->idPessoa}','{$hist->idServico}','{$hist->descricao}','{$hist->valor}','{$hist->data}');";
        $resultado = \Utils\Data\MySQL::Instance()->execute($qry);
        if(!$resultado->isSuccess()){
            return null;
        }
        
        $hist->id = $resultado->getInsertID();
        
        return $hist;
    }
    
    /**
     * @param \Models\Historico $hist
     * @return boolean
     */
    public function alterarHistorico(\Models\Historico $hist){        
        $qry = "UPDATE historicos SET idPessoa = '{$hist->idPessoa}', idServico = '{$hist->idServico}', descricao = '{$hist->descricao}', valor = '{$hist->valor}', data = '{$hist->data}' 
                WHERE id = '{$hist->id}';";
        $resultado = \Utils\Data\MySQL::Instance()->execute($qry);
        return $resultado->isSuccess();
    }
    
    /**
     * @param int $id
     * @return boolean
     */
    public function excluirHistorico($id){
        $qry = "DELETE FROM historicos WHERE id = '$id';";
        $resultado = \Utils\Data\MySQL::Instance()->execute($qry);
        return $resultado->isSuccess();
    }
}
