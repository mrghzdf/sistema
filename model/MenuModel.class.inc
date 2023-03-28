<?php

class MenuModel extends Conexao
{
    protected $stNomeTabela = "fbb_sistema.tbl_pagina_menu";

    protected $chavePrimaria = 'id_pg_menu';

    function get($id)
    {
        try {
            $sql = "SELECT * from {$this->stNomeTabela} WHERE {$this->chavePrimaria} = {$id}";
            return $this->pegaLinha($sql);

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    function inativarAtivar($id)
    {
        try {

            $status = $this->pegaUm("SELECT st_pg_menu FROM {$this->stNomeTabela} WHERE  {$this->chavePrimaria} = {$id}");
            $status = $status == 1 ? 0 : 1;
            $sql = "UPDATE {$this->stNomeTabela} SET st_pg_menu = {$status} WHERE {$this->chavePrimaria} = {$id}";
            return  $this->executar($sql) ? true : false;

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    function salvar($arrPost = [])
    {
        try {
            extract($arrPost);


            if (empty($id_pg_menu)) { // Insert
                $sql = "INSERT
                    INTO
                        {$this->stNomeTabela}
                        (
                            nm_pg_menu,
                            nm_image,
                            nr_ordem,
                            id_pagina,
                            st_home,
                            url_externa,
                            st_visivel
                        )
                        VALUES
                        (
                            '{$nm_pg_menu}',
                            '{$nm_image}',
                             {$nr_ordem},
                             {$id_pagina},
                             {$st_home},
                            '{$url_externa}',
                             {$st_visivel}
                        )
                    ";


            } else {  // Update
                $sql = "UPDATE
                            {$this->stNomeTabela}
                        SET
                            nm_pg_menu = '{$nm_pg_menu}',
                            nm_image = '{$nm_image}',
                            nr_ordem =  {$nr_ordem},
                            id_pagina =  {$id_pagina},
                            st_home =  {$st_home},
                            url_externa = '{$url_externa}',
                            st_visivel = {$st_visivel}
                        WHERE
                            id_pg_menu = {$id_pg_menu}
                        ";
            }
            return $this->executar($sql);

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }


}