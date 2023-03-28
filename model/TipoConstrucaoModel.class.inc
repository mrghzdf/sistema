<?php

class TipoConstrucaoModel extends Conexao
{
    protected $stNomeTabela = "fbb_sistema.tbl_tipo_construcao";

    protected $arChavePrimaria = array(
        'id_tp_construcao'
    );

    function listAll()
    {
        try {
            $sql = "SELECT * from {$this->stNomeTabela} WHERE st_tp_contrucao = 1";
            return $this->carregar($sql);

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }
}