<?php

class CisternaModel extends Conexao
{
    protected $stNomeTabela = "fbb_sistema.tbl_cisterna";

    protected $chavePrimaria = 'id_cisterna';

    function get($id)
    {
        try {
            $sql = "SELECT * from {$this->stNomeTabela} WHERE {$this->chavePrimaria} = {$id} ORDER BY dt_cadastro desc";
            $arDados = $this->pegaLinha($sql);

            $arNew = [
                'fk_id_entidade' => $arDados['fk_id_entidade'],
                'id_cisterna' => $arDados['id_cisterna'],
                'fk_id_tp_construcao' => $arDados['fk_id_tp_construcao'],
                'fk_id_pais' => $arDados['fk_id_pais'],
                'fk_id_estado' => $arDados['fk_id_estado'],
                'fk_id_cidade' => $arDados['fk_id_cidade'],
                'dsc_materiais' => $arDados['dsc_materiais'],
                'nm_bairro' => $arDados['nm_bairro'],
                'nm_endereco' => $arDados['nm_endereco'],
                'nr_latitude' => $arDados['nr_latitude'],
                'nr_longitude' => $arDados['nr_longitude'],
                'dt_inauguracao' => $arDados['dt_inauguracao'],
                'st_cisterna' => $arDados['st_cisterna'],
            ];
            return $arNew;

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    function inativarAtivar($id)
    {
        try {
            $status = $this->pegaUm("SELECT st_cisterna 
                                     FROM {$this->stNomeTabela} 
                                     WHERE  {$this->chavePrimaria} = {$id}");
            $status = $status == 1 ? 0 : 1;
            $sql = "UPDATE {$this->stNomeTabela} SET st_cisterna = {$status} WHERE {$this->chavePrimaria} = {$id}";
            return $this->executar($sql) ? true : false;
        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    function salvar($arrPost = [])
    {
        try {
            extract($arrPost);
            $nr_latitude = !empty($nr_latitude) ? $nr_latitude : 'null';
            $nr_longitude = !empty($nr_longitude) ? $nr_longitude : 'null';

            if (empty($id_cisterna)) { // Insert
                $sql = "INSERT INTO
                        `fbb_sistema`.`tbl_cisterna`
                        (
                            `fk_id_entidade`,
                            `fk_id_tp_construcao`,
                            `fk_id_pais`,
                            `fk_id_estado`,
                            `fk_id_cidade`,
                            `dsc_materiais`,
                            `nm_bairro`,
                            `nm_endereco`,
                            `dt_inauguracao`,
                            `nr_latitude`,
                            `nr_longitude`
                        )
                        VALUES
                        (
                            {$fk_id_entidade},
                            {$fk_id_tp_construcao},
                            {$fk_id_pais},
                            {$fk_id_estado},
                            {$fk_id_cidade},
                            '{$dsc_materiais}',
                            '{$nm_bairro}',
                            '{$nm_endereco}',
                            '{$dt_inauguracao}',
                            {$nr_latitude},
                            {$nr_longitude}
                        )";

            } else {  // Update
                $sql = "UPDATE
                            `fbb_sistema`.`tbl_cisterna`
                        SET
                            `fk_id_entidade` =  {$fk_id_entidade},
                            `fk_id_tp_construcao` =  {$fk_id_tp_construcao},
                            `fk_id_pais` = {$fk_id_pais},
                            `fk_id_estado` = {$fk_id_estado},
                            `fk_id_cidade` = {$fk_id_cidade},
                            `dsc_materiais` = '{$dsc_materiais}',
                            `nm_bairro` = '{$nm_bairro}',
                            `nm_endereco` = '{$nm_endereco}',
                            `dt_inauguracao` =   '{$dt_inauguracao}',
                            `nr_latitude` = {$nr_latitude},
                            `nr_longitude` = {$nr_longitude}
                        WHERE
                            `id_cisterna` = {$id_cisterna}";
            }

            return $this->executar($sql);

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }


}