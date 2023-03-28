<?php

class CidadeModel extends Conexao
{
    protected $stNomeTabela = "fbb_sistema.tbl_cidade";

    protected $arChavePrimaria = array(
        'id_cidade'
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