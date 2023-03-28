<?php

class UsuarioModel extends Conexao
{
    protected $stNomeTabela = "fbb_sistema.tbl_usuario";

    protected $arChavePrimaria = array(
        'id_usuario'
    );

    function getUsuarioByMatricula($matricula)
    {
        try {
            $RS = $this->carregar("SELECT * FROM {$this->stNomeTabela} WHERE nm_login = '{$matricula}' ");
            return $RS->fetch();
        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    public function saveUsuario($arrPost =[])
    {
        try {
            $nm_login = $arrPost['nm_login'];
            $senha = md5($arrPost['nm_senha']);

            $sql = "SELECT COUNT(id_usuario) FROM fbb_sistema.tbl_usuario WHERE nm_login = '{$nm_login}'";
            $boolExiste = $this->pegaUm($sql);

            if(empty($boolExiste)) {

                $boolInsert = $_SESSION['id_perfil'] <> PLDCOD_SUPER_USUARIO && $arrPost['id_perfil'] == PLDCOD_SUPER_USUARIO ? false : true;

                if(!$boolInsert){
                    return false;
                } else {
                    $sql = "INSERT INTO {$this->stNomeTabela} ( nm_login, nm_senha, st_usuario, id_perfil) 
                                                     VALUES ( '{$nm_login}', '{$senha}','{$arrPost['st_usuario']}', '{$arrPost['id_perfil']}' )";
                    $stmt = $this->executar($sql);
                }

            } else {
                return 2;
            }
            return $stmt ? true : false;

        } catch (PDOException $ex) {
            $this->conex->rollBack();
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    public function updateUsuario($arrPost =[])
    {
        try {
            $nm_login = $arrPost['nm_login'];
            $senha = md5(trim($arrPost['nm_senha']));
            $isSuper = $_SESSION['id_perfil'] == PLDCOD_SUPER_USUARIO;
            $userAnteriorIsSuper = $this->pegaUm("SELECT id_perfil FROM fbb_sistema.tbl_usuario WHERE id_usuario = {$arrPost['id_usuario']}") == PLDCOD_SUPER_USUARIO;

            // Usuário que não é super usuário tentando atribuir um perfil de SU para outro.
            if( !$isSuper && $arrPost['id_perfil'] == PLDCOD_SUPER_USUARIO ){
                $boolUpdate = 0;

            // Não é super usuário e está tentanto retirar o perfil de super usuário do empregado.
            } else if( !$isSuper && $userAnteriorIsSuper && $arrPost['id_perfil'] <> PLDCOD_SUPER_USUARIO){
                $boolUpdate = 0;
            } else {
                $boolUpdate = 1;
            }

            if( !$boolUpdate ){
                return 0;

            } else {
                $checkSenha = strtolower($arrPost['nm_senha']);
                $boolIgual = $this->pegaUm( "SELECT COUNT(id_usuario) FROM fbb_sistema.tbl_usuario WHERE nm_senha = '{$checkSenha}'");

                if($boolIgual == 1){
                    $sql = "UPDATE {$this->stNomeTabela} SET nm_login = '{$nm_login}',st_usuario='{$arrPost['st_usuario']}', 
                            id_perfil='{$arrPost['id_perfil']}' WHERE id_usuario = {$arrPost['id_usuario']}";
                    $stmt = $this->executar($sql);
                    return $stmt ? 1 : 0;
                    
                } else {
                    $sql = "UPDATE {$this->stNomeTabela} SET nm_login = '{$nm_login}', nm_senha='{$senha}', 
                            st_usuario='{$arrPost['st_usuario']}', id_perfil='{$arrPost['id_perfil']}' WHERE id_usuario = {$arrPost['id_usuario']}";
                    $stmt = $this->executar($sql);
                    return $stmt ? 1 : 0;
                }
            }
        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    public function inativarUsuario($id)
    {
        try {
            $sql = "UPDATE {$this->stNomeTabela} SET st_usuario = '0' WHERE id_usuario = {$id}";
            $stmt = $this->executar($sql);
            echo $stmt ? true : false;

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    public function listUsuario($query = null, $limit = false, $start = null, $end = null)
    {
        try {

            if ($limit == true) {
                $limit = 'OFFSET ' . $start . ' LIMIT ' . $end;
            } else {
                $limit = null;
            }

            if ($query == null) {

                if($_SESSION["id_perfil"] == PLDCOD_SUPER_USUARIO) {
                    $sql = "SELECT 
                            u.*,
                            perfil.nm_perfil,
                            perfil.id_nivel as id_nivel,
                          FROM {$this->stNomeTabela} u 
                          JOIN fbb_sistema.tbl_perfil perfil ON perfil.id_perfil = u.id_perfil
                          ORDER BY f.nm_login
                      {$limit} ";
                } else {
                    $sql = "SELECT 
                            u.*,
                            perfil.nm_perfil,
                            perfil.id_nivel as id_nivel
                          FROM {$this->stNomeTabela} u 
                            JOIN fbb_sistema.tbl_perfil perfil ON perfil.id_perfil = u.id_perfil
                          WHERE id_nivel >= {$_SESSION['id_nivel_perfil']} 
                          ORDER BY u.nm_login
                      {$limit} ";
                }
                $stmt = $this->carregar($sql);

            } else {
                $stmt = $this->carregar($query);
            }

            return $stmt;

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }

    function getUsuarioById($id_usuario)
    {
        try {
            $sql = "SELECT 
                      u.*,
                      u.nm_login,
                      perfil.id_nivel as id_nivel
                    FROM {$this->stNomeTabela} u 
                    JOIN fbb_sistema.tbl_perfil perfil ON perfil.id_perfil = u.id_perfil
                    WHERE id_usuario = {$id_usuario}";
            $RS = $this->pegaLinha($sql);
            return $RS;

        } catch (PDOException $ex) {
            throw new PDOException('Erro: ' . $ex->getMessage());
        }
    }
}