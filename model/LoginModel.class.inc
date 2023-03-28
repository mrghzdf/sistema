<?php
class LoginModel extends Conexao
{
    protected $stNomeTabela = "fbb_sistema.tbl_usuario";

    protected $arChavePrimaria = array(
        'id_usuario'
    );

    public function getUserLogin($arPost = [])
    {
        extract($arPost);
        $sql = "SELECT
                    u.*,
                    p.id_nivel AS id_nivel,
                    p.nm_perfil,
                   ( SELECT  date_format((dt_acao), '%d/%m/%Y %h:%i:%s') as ultimo_acesso from fbb_sistema.tbl_auditoria 
                      where id_usuario = u.id_usuario and tbl_auditoria.dsc_acao = 'Acesso ao sistema' order by dt_acao desc limit 1,1 ) as ultimo_acesso,
                    ( SELECT MAX(id_nivel) FROM fbb_sistema.tbl_perfil where st_perfil = 1 ) AS ultimo_nivel
                FROM
                    fbb_sistema.tbl_usuario u
                JOIN fbb_sistema.tbl_perfil p ON p.id_perfil = u.id_perfil
                WHERE u.nm_login = '{$nm_login}' 
                    AND u.st_usuario = 1";
        $arrUsuario = $this->query($sql)->fetch();
        return $arrUsuario ? $arrUsuario : [];
    }

    /** Log de acesso ao sistema
     * @param $id_usuario
     * @return bool
     */
    function saveLogAcessoAuditoria($id_usuario)
    {
        $sql =  "INSERT
                    INTO
                        `fbb_sistema`.`tbl_auditoria`
                        (
                            `dsc_acao`,
                            `id_usuario`,
                            `dt_acao`
                        )
                        VALUES
                        (
                            'Acesso ao sistema',
                            {$id_usuario},
                            now()
                        );
                    ";
        return $this->executar($sql);
    }

    public function getMenusByPerfil($id_perfil)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".'sistema/view/app/';

        $sql = "SELECT
                   concat( concat('{$actual_link}', m.url_menu ), '/') as url_menu
                FROM
                    `fbb_sistema`.`tbl_perfil` p
                    join fbb_sistema.tbl_perfil_menu pm ON pm.id_perfil = p.id_perfil
                    join fbb_sistema.tbl_menu m ON m.id_menu = pm.id_menu
                WHERE 
                        p.id_perfil = {$id_perfil}
                        AND trim(m.url_menu) <> ''
                        AND p.st_perfil = 1 AND m.st_menu = 1
                ";
        $arUrls = $this->carregar($sql);
        return $arUrls ? $arUrls : [];
    }
}


