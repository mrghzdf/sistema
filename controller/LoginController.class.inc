<?php
require_once APPRAIZ . "/model/LoginModel.class.inc";

class LoginController
{
    function userLogin( $arPost = [] )
    {
        try {
            extract($arPost);
            $loginModel = new LoginModel();
            $row = $loginModel->getUserLogin( $arPost );

            if (sizeof($row) > 0) {

                // Agora verifica a senha
                if ( !strcmp( strtoupper(md5($arPost['senha'])), strtoupper($row['nm_senha'])) ){
                    date_default_timezone_set('America/Sao_Paulo');

                    if ( (int)$row["st_usuario"] == 1) {
                            session_start();
                            $_SESSION["id_usuario"] = $row["id_usuario"];
                            $_SESSION["nm_login"] = $row["nm_login"];
                            $_SESSION["ultimo_acesso"] =$row["ultimo_acesso"];
                            $_SESSION["id_perfil"] = $row['id_perfil'];
                            $_SESSION["nm_perfil"] = $row['nm_perfil'];
                            $_SESSION["id_nivel_perfil"] = $row['id_nivel'];
                            $_SESSION["ultimo_nivel_perfil"] = $row['ultimo_nivel'];
                            $_SESSION['arMenus'] = $loginModel->getMenusByPerfil($row['id_perfil']);

                            // Salva log de acesso
                            $loginModel->saveLogAcessoAuditoria($row['id_usuario']);
                            echo "<script>document.location.href='view/app/home/';</script>";

                        } else {
                            echo "<script>alert('Você não tem permissão para acessar o sistema.');</script>";
                            echo "<script>history.go(-1);</script>";
                    }

                } else {
                    echo "<script>alert('Senha inválida.');</script>";
                    echo "<script>history.go(-1);</script>";

                }

                // Login inválido
            } else {
                echo "<script>alert('Nome de usuário inexistente.');</script>";
                echo "<script>history.go(-1);</script>";
            }

        } catch (PDOException $e) {
            return "There is some problem in connection:" . $e->getMessage();
        }
    }
}