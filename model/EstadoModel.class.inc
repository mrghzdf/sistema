<?php

class EstadoModel extends Conexao
{
    protected $stNomeTabela = "fbb_sistema.tbl_estado";

    protected $arChavePrimaria = array(
        'id_estado'
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