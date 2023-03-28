<?php
require_once '../../../config.php';

# Classes
$usuarioController = new UsuarioController();
$perfilController = new PerfilController();

# Requisicao GET de AJAX - Verificando se tem requisicao ajax, se tiver chama a funcao e finaliza a pagina.
if (isset($_REQUEST['ajax']) && $_REQUEST['ajax']) {
    switch ($_REQUEST['ajax']) {
        case 'salvarUsuario':
            echo $usuarioController->saveUsuario($_POST);
            break;
        case 'atualizarUsuario':
            echo $usuarioController->updateUsuario($_POST);
            break;
        case 'inativarUsuario':
            echo $usuarioController->inativarUsuario($_POST['id_usuario']);
            break;
        default:
            echo 'Ação ajax não encontrada';
            break;
    }
    exit;
}

# Alteração
if (isset($_GET['acao']) && $_GET['acao'] === 'A') {
    $strLabel = 'Alterar';
    $strAviso = 'Alterados';
    $arrUsuario = $_REQUEST['id_usuario'] ? $usuarioController->getUsuarioById($_REQUEST['id_usuario']) : array();

# Inclusão
} else {
    $strLabel = 'Incluir';
    $strAviso = 'Incluído';
    $arrUsuario = array();
}

$arrListaUsuario = $usuarioController->listUsuario();
$totalRegistros = sizeof($arrListaUsuario);
?>
<?php require_once APPRAIZ . '/view/template/header.inc'; ?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Usuários</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="container-fluid text-center">
    <div class="row justify-content-center align-items-center">
        <div class="col-10 caixa-texto">
            <div class="row-fluid">
                <div class="cad_titulo_sub_pesquisar">
                    <label>Resultado ( <?= $totalRegistros ?> )</label>
                </div>
                <table id="tabela-usuario" class="display table_datatable dataTable">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Perfil</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($arrListaUsuario as $strKey => $strValue) {
                        ?>
                        <tr>
                            <td><?= strtoupper($strValue['nm_login']) ?></td>
                            <td><?= $strValue['nm_perfil'] ?></td>
                            <td><?= ($strValue['st_usuario'] == '1') ? 'Ativo' : 'Inativo' ?></td>
                            <td>
                                <div align="center">
                                    <?php if ($strValue['st_usuario'] == '1') { ?>
                                        <a href="#"><img src="<?= HOME_URI ."assets/images/icones/delete.png"?>" onclick="inativarUsuario('<?= $strValue['id_usuario'] ?>');"></a>
                                    <?php } ?>&nbsp;
                                    <a href="?acao=A&id_usuario=<?= $strValue['id_usuario'] ?>"><img
                                                src="<?= HOME_URI ."assets/images/icones/application_edit.png"?>"></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-12 text-left mt-2">
                        <button type="button" class="btn btn-success pull-left btn-novo">
                            <i class="fa fa-plus-circle"></i> Novo
                        </button>
                    </div>
                </div>
                <div class="row cadastro"
                     style="margin-top: 20px; <?= isset($_REQUEST['acao']) && $_REQUEST['acao'] == 'A' ? '' : 'display: none;' ?>">
                    <div class="col-md-12">
                        <h2 class="h2-titulo"><?= $strLabel ?> usuário</h2>
                        <form id="form-usuario" class="form" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>"
                              enctype="multipart/form-data">
                            <input type="hidden" name="acao" id="acao" value="<?= $_REQUEST['acao'] ?>"/>
                            <input type="hidden" name="ajax" id="ajax"/>
                            <input type="hidden" name="id_usuario" id="id_usuario"
                                   value="<?= $_REQUEST['id_usuario'] ?>"/>
                            <div class="div-legenda-fieldset">Dados do usuário</div>
                            <fieldset class="well caixa-fieldset">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Nome de usuário:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="nm_login" id="nm_login"
                                               placeholder="Nome"
                                               value="<?= isset($arrUsuario['nm_login']) ? $arrUsuario['nm_login'] : '' ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Perfil:</label>
                                    <div class="col-sm-6">
                                        <?php
                                        $arrPerfil = $perfilController->listarPerfil();
                                        ?>
                                        <select class="form-control" name="id_perfil" id="id_perfil">
                                            <option value="">Selecione...</option>
                                            <?php
                                            foreach ($arrPerfil as $strKey => $strValue) {
                                                ?>
                                                <option value="<?= $strValue['id_perfil'] ?>" <?= isset($arrUsuario['id_perfil']) && $arrUsuario['id_perfil'] == $strValue['id_perfil'] ? 'selected' : '' ?>><?=$strValue['nm_perfil'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                if(isset( $_REQUEST['acao']) &&  $_REQUEST['acao'] == 'A'):
                                ?>
                                <?php endif;?>
                                    <div class="form-group row" id="divSenha">
                                        <label class="col-sm-2 col-form-label">* Senha:</label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" name="nm_senha"
                                                   id="nm_senha" value="<?= isset($arrUsuario['nm_senha']) ? $arrUsuario['nm_senha'] : '' ?>">
                                        </div>
                                    </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Status:</label>
                                    <div class="col-sm-6 " style="text-align: left;">
                                        <label class="radio-inline"><input type="radio" name="st_usuario"
                                                                           value="1" <?= isset($arrUsuario['st_usuario']) && $arrUsuario['st_usuario'] == '1' ? 'checked' : '' ?>
                                            > Ativo</label>
                                        <label class="radio-inline"><input type="radio" name="st_usuario"
                                                                           value="0" <?= ( isset($arrUsuario['st_usuario']) && $arrUsuario['st_usuario'] == '0') ? 'checked' : '' ?>> Inativo</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-8 text-left  col-sm-offset-2">
                                        <input type="button" class="btn btn-danger"
                                               onclick="location.href='index.php?acao=I'" value="Cancelar">
                                        <input type="button" class="btn btn-success" name="btn-salvar"
                                               id="btn-salvar"
                                               value="<?= $strLabel ?>">

                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APPRAIZ . '/view/template/footer.inc'; ?>
<script type="text/javascript" src="<?= HOME_URI . "assets/js/manter.usuario.js" ?>"></script>
</body>
</html>