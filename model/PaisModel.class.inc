<?php

class PaisModel extends Conexao
{
    protected $stNomeTabela = "fbb_sistema.tbl_pais";

    protected $arChavePrimaria = array(
        'id_pais'
    );

    function listAll()
    {
        try {
            $sql = "SELECT * from {$this->stNomeTabela}";
            return $this->carregar($sql);

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }
}