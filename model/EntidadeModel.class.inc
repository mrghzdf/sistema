<?php

class EntidadeModel extends Conexao
{
    protected $stNomeTabela = "fbb_sistema.tbl_entidade";

    protected $chavePrimaria = 'id_entidade';

    public function listEntidade()
    {
        try {
            $sql = "SELECT e.id_entidade, e.nm_fantasia FROM
                    fbb_sistema.tbl_entidade e
                    WHERE e.st_entidade = 1";
            return $this->carregar($sql);
        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    function get($id)
    {
        try {
            $sql = "SELECT * from {$this->stNomeTabela} 
                    WHERE {$this->chavePrimaria} = {$id} 
                    ORDER BY dt_cadastro desc";
            $arDados = $this->pegaLinha($sql);

            // Pegar todas as cistarnas cadastradas
            $sql = "SELECT 
                    c.id_cisterna,
                    concat('ID: ', c.id_cisterna, ' - ', e.nome, ' - ', cid.nome ) as cisterna
                    FROM fbb_sistema.tbl_entidade ent
                    LEFT JOIN fbb_sistema.tbl_cisterna c ON c.fk_id_entidade = ent.id_entidade
                    JOIN fbb_sistema.tbl_pais p ON p.id_pais = ent.fk_id_pais
                    JOIN fbb_sistema.tbl_estado e ON e.id_estado = ent.fk_id_estado
                    JOIN fbb_sistema.tbl_cidade cid ON cid.id_cidade = ent.fk_id_cidade
                    WHERE fk_id_entidade = {$id}";
            $arCisternas = $this->carregar($sql);

            $arNew = [
                'id_entidade' => $arDados['id_entidade'],
                'nm_fantasia' => $arDados['nm_fantasia'],
                'nr_cnpj' => $arDados['nr_cnpj'],
                'fk_id_pais' => $arDados['fk_id_pais'],
                'fk_id_estado' => $arDados['fk_id_estado'],
                'fk_id_cidade' => $arDados['fk_id_cidade'],
                'nr_cep' => $arDados['nr_cep'],
                'nm_bairro' => $arDados['nm_bairro'],
                'nm_endereco' => $arDados['nm_endereco'],
                'nr_ddd' => $arDados['nr_ddd'],
                'nr_telefone' => $arDados['nr_telefone'],
                'nm_observacao' => $arDados['nm_observacao'],
                'st_entidade' => $arDados['st_entidade'],
                'ids_cisterna' => $arCisternas,
            ];
            return $arNew;

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    function inativarAtivar($id)
    {
        try {
            $status = $this->pegaUm("SELECT st_entidade 
                                          FROM {$this->stNomeTabela} 
                                          WHERE  {$this->chavePrimaria} = {$id}");
            $status = $status == 1 ? 0 : 1;
            $sql = "UPDATE {$this->stNomeTabela} 
                    SET st_entidade = {$status} WHERE {$this->chavePrimaria} = {$id}";
            return $this->executar($sql) ? true : false;
        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    function salvar($arrPost = [])
    {
        try {
            extract($arrPost);

            if (empty($id_entidade)) {
                $sql = "INSERT INTO
                        `fbb_sistema`.`tbl_entidade`
                        (
                            `nm_fantasia`,
                            `nr_cnpj`,
                            `fk_id_pais`,
                            `fk_id_estado`,
                            `fk_id_cidade`,
                            `nr_cep`,
                            `nm_bairro`,
                            `nm_endereco`,
                            `nr_ddd`,
                            `nr_telefone`,
                            `nm_observacao`
                        )
                        VALUES
                        (
                            '{$nm_fantasia}',
                            '{$nr_cnpj}',
                            {$fk_id_pais},
                            {$fk_id_estado},
                            {$fk_id_cidade},
                            '{$nr_cep}',
                            '{$nm_bairro}',
                            '{$nm_endereco}',
                            {$nr_ddd},
                            '{$nr_telefone}',
                            '{$nm_observacao}'
                        )";

            } else {
                $sql = "UPDATE
                            `fbb_sistema`.`tbl_entidade`
                        SET
                            `nm_fantasia` =  '{$nm_fantasia}',
                            `nr_cnpj` = '{$nr_cnpj}',
                            `fk_id_pais` = {$fk_id_pais},
                            `fk_id_estado` = {$fk_id_estado},
                            `fk_id_cidade` = {$fk_id_cidade},
                            `nr_cep` = '{$nr_cep}',
                            `nm_bairro` = '{$nm_bairro}',
                            `nm_endereco` = '{$nm_endereco}',
                            `nr_ddd` = {$nr_ddd},
                            `nr_telefone` = '{$nr_telefone}',
                            `nm_observacao` = '{$nm_observacao}'
                        WHERE
                            `id_entidade` = {$id_entidade}";

            }

            return $this->executar($sql);

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

}