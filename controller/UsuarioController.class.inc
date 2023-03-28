<?php
require_once APPRAIZ . "/model/UsuarioModel.class.inc";


class UsuarioController
{

    function listUsuario()
    {
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->listUsuario();
    }

    function getUsuarioByMatricula($matricula)
    {
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->getUsuarioByMatricula($matricula);
    }

    function atualizarSenha($senha, $id_usuario)
    {
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->atualizarSenha($senha,$id_usuario);
    }

    function saveUsuario($arrPost)
    {
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->saveUsuario($arrPost);
    }

    public function updateUsuario($arrPost =[])
    {
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->updateUsuario($arrPost);
    }

    function inativarUsuario($id)
    {
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->inativarUsuario($id);
    }

    function getUsuarioById($id_usuario)
    {
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->getUsuarioById($id_usuario);
    }

    function htmlEmailRecuperarSenha()
    {
        // Senha randômica de 4 dígitos
        $html = "";
        $html .= "<html>";
        $html .= "<head>";
        $html .= "</head>";
        $html .= "<body>";
        $html .= "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-family:Verdana;\">";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\"><b>Administrador UPCTRL:</b>&nbsp;Recuperação de Senha</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">&nbsp;</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">Seus dados para acesso ao sistema são:</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">&nbsp;</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">E-mail:&nbsp;" . $emailUsuario . "</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">Senha:&nbsp;<b>" . $novaSenha . "</b></td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">Link sistema:&nbsp;<b>" . LINK_SISTEMA . "</b></td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">&nbsp;</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:10px;\">Este e-mail foi enviado automaticamente, favor não respondê-lo.</td>";
        $html .= "</tr>";
        $html .= "</table>";
        $html .= "</body>";
        $html .= "</html>";
        return $html;
    }

    function htmlEmailNovoCadastro($emailUsuario, $novaSenha)
    {
        // Senha randômica de 4 dígitos
        $html = "";
        $html .= "<html>";
        $html .= "<head>";
        $html .= "</head>";
        $html .= "<body>";
        $html .= "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-family:Verdana;\">";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\"><b>Administrador UPCTRL:</b>&nbsp;Novo cadastro</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">&nbsp;</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">Seus dados para acesso ao sistema são:</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">&nbsp;</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">CPF:&nbsp;" . $emailUsuario . "</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">Senha:&nbsp;<b>" . $novaSenha . "</b></td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">Link sistema:&nbsp;<b>" . LINK_SISTEMA . "</b></td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px; color: red;\"><br><br>Atenção! Para alterar a senha temporária clique no menu sistema -> atualização cadastração -> Campo nova senha</b></td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:12px;\">&nbsp;</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td colspan=\"3\" align=\"left\" style=\"font-size:10px;\">Este e-mail foi enviado automaticamente, favor não respondê-lo.</td>";
        $html .= "</tr>";
        $html .= "</table>";
        $html .= "</body>";
        $html .= "</html>";
        return $html;
    }
}