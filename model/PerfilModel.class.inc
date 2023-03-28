<?php

class PerfilModel extends Conexao
{
    protected $stNomeTabela = "perfil";

    protected $arChavePrimaria = array(
        'id_perfil'
    );

    public function savePerfil($arrPost = array())
    {
        try {
            $sql = "INSERT INTO perfil (id_perfil, nme_perfil, sta_perfil) VALUES ( perfil_seq.nextval, '{$arrPost['nme_perfil']}', '{$arrPost['sta_perfil']}' )";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute();
            logAuditoria('Inclusão de Perfil', $sql);
            return true;

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    function pdo_debugStrParams($stmt)
    {
        ob_start();
        $stmt->debugDumpParams();
        $r = ob_get_contents();
        ob_end_clean();
        return $r;
    }

    public function updatePerfil($arrPost = array())
    {
        try {
            $sql = "UPDATE perfil SET nme_perfil = '{$arrPost['nme_perfil']}', sta_perfil='{$arrPost['sta_perfil']}' WHERE id_perfil = {$arrPost['id_perfil']} ";
            $stmt = $this->conex->prepare($sql);
            logAuditoria('Atualização de Perfil', $sql);
            return $stmt->execute();

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }


    public function inativarPerfil($id_perfil)
    {
        try {
            $perfil = $_SESSION['id_perfil'] <> PLDCOD_SUPER_USUARIO ? ' AND perfil.id_perfil <> ' . PLDCOD_SUPER_USUARIO : '';

            $sql = "UPDATE {$this->stNomeTabela} SET sta_perfil ='I' WHERE id_perfil = {$id_perfil}";
            $stmt = $this->conex->prepare("UPDATE {$this->stNomeTabela} SET sta_perfil ='I' WHERE id_perfil = {$id_perfil}");
            logAuditoria('Invativação de Perfil', $sql);
            echo $stmt->execute();

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    public function listarPerfil($query = null, $limit = false, $start = null, $end = null)
    {
        try {

            // Vê todos os perfis ativos do sistema
            if ($_SESSION["id_perfil"] == PLDCOD_SUPER_USUARIO) {
                $sql = "SELECT * FROM fbb_sistema.tbl_perfil WHERE st_perfil = 1 ORDER BY nm_perfil ASC";

            } else {
                // Só consegue atribuir um perfil com um nível menor ou igual ao do usuário logado do mesmo módulo
                $sql = "SELECT * FROM 
                        fbb_sistema.tbl_perfil p 
                        WHERE id_nivel >= {$_SESSION['id_nivel_perfil']} 
                        AND p.st_perfil = 1
                        ORDER BY nm_perfil ASC";
            }
            $dados = $this->carregar($sql);
            return $dados;
        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    /** Obtém a lista de menus a parti do pai e perfil correspodente.
     * @param $id_menu_pai
     * @return mixed
     */
    function getMenuByPerfil($id_perfil)
    {
        try {

            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . 'sistema/view/app/';

            $sql = "select m.*,
                   concat( concat('{$actual_link}', m.url_menu ), '/') as url_menu
                    from fbb_sistema.tbl_perfil p
                    join fbb_sistema.tbl_perfil_menu pm ON pm.id_perfil = p.id_perfil
                    join fbb_sistema.tbl_menu m ON m.id_menu = pm.id_menu
                  WHERE  p.id_perfil = {$id_perfil} AND m.st_menu = 1
                  ORDER BY id_menu_pai, nro_ordem;";
            $arDados = $this->carregar($sql);
            return $arDados;
        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }

    }

    public function getPerfilById($id)
    {
        try {
            $RS = $this->conex->query("SELECT * FROM perfil WHERE id_perfil = '" . $id . "' ");
            return $RS->fetch();
        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }
}