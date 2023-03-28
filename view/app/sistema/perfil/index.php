<?php
require_once '../../../config.php';

# Classes
$conexao = new Conexao();

# Requisicao GET de AJAX - Verificando se tem requisicao ajax, se tiver chama a funcao e finaliza a pagina.
if (isset($_REQUEST['ajax']) && $_REQUEST['ajax']) {
    switch ($_REQUEST['ajax']) {
        case 'salvarPerfil':
            $sql = "SELECT COUNT(id_perfil) FROM fbb_sistema.tbl_perfil WHERE id_perfil = '{$_REQUEST['id_perfil']}'";
            $boolExiste = $conexao->pegaUm($sql);

            if ((int)($boolExiste) == 0) {
                $sql = "INSERT
                            INTO
                                `fbb_sistema`.`tbl_perfil`
                                (
                                    `nm_perfil`,
                                    `dsc_perfil`,
                                    `id_nivel`
                                )
                                VALUES
                                (
                                    '{$_REQUEST['nm_perfil']}',
                                   '{$_REQUEST['dsc_perfil']}',
                                   '{$_REQUEST['id_nivel']}'
                                );
                            ";
                echo $conexao->executar($sql);
            } else {
                echo 0;
            }

            break;
        case 'atualizarPerfil':
            $sql = "UPDATE
                        `fbb_sistema`.`tbl_perfil`
                    SET
                        `nm_perfil` = '{$_REQUEST['nm_perfil']}',
                        `dsc_perfil` = '{$_REQUEST['dsc_perfil']}',
                        `id_nivel` = '{$_REQUEST['id_nivel']}',
                        `st_perfil` = '{$_REQUEST['st_perfil']}'
                    WHERE
                        `id_perfil` = {$_REQUEST['id_perfil']};
                    ";
            echo $conexao->executar($sql);
            break;
        case 'inativarPerfil':
            $sql = "UPDATE fbb_sistema.tbl_perfil SET st_perfil = 0 WHERE id_perfil = '{$_REQUEST['id_perfil']}';";
            echo $conexao->executar($sql);
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

    if ($_REQUEST['id_perfil']) {
        $arPerfil = $conexao->pegaLinha("SELECT * FROM fbb_sistema.tbl_perfil WHERE id_perfil = '{$_REQUEST['id_perfil']}'");
    }
# Inclusão
} else {
    $strLabel = 'Incluir';
    $strAviso = 'Incluído';
    $arPerfil = array();
}

// Lista
$sql = "SELECT * FROM fbb_sistema.tbl_perfil ORDER BY id_nivel";
$arDados = $conexao->carregar($sql);
$totalRegistros = sizeof($arDados);
?>
<?php require_once APPRAIZ . '/view/template/header.inc'; ?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Perfis</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="container-fluid text-center">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-10 col-md-offset-1 caixa-texto">
            <div class="row-fluid">
                <div class="cad_titulo_sub_pesquisar">
                    <label>Resultado ( <?= $totalRegistros ?> )</label>
                </div>
                <table id="tabela-usuario" class="display table_datatable dataTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Perfil</th>
                        <th>Descrição</th>
                        <th>Nível</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($arDados as $strKey => $strValue) {
                        ?>
                        <tr>
                            <td><?= $strValue['id_perfil'] ?></td>
                            <td><?= $strValue['nm_perfil'] ?></td>
                            <td><?= $strValue['dsc_perfil'] ?></td>
                            <td><?= $strValue['id_nivel'] ?></td>
                            <td><?= $strValue['st_perfil'] == 1 ? 'Ativo' : 'Inativo' ?></td>
                            <td>
                                <div align="center">
                                    <a href="#"><img src="<?= HOME_URI . "assets/images/icones/delete.png" ?>"
                                                     onclick="inativarPerfil('<?= $strValue['id_perfil'] ?>');"></a>
                                    <a href="?acao=A&id_perfil=<?= $strValue['id_perfil'] ?>"><img
                                                src="<?= HOME_URI . "assets/images/icones/application_edit.png" ?>"></a>
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
                        <h2 class="h2-titulo"><?= $strLabel ?> perfil</h2>
                        <form id="frmPerfil" class="form text-left" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>"
                              enctype="multipart/form-data">
                            <input type="hidden" name="acao" id="acao" value="<?= $_REQUEST['acao'] ?>"/>
                            <input type="hidden" name="ajax" id="ajax"/>
                            <input type="hidden" name="id_perfil" id="id_perfil"
                                   value="<?= isset($_REQUEST['id_perfil']) ? $_REQUEST['id_perfil'] : '' ?>"/>
                            <div class="div-legenda-fieldset">Dados do perfil</div>
                            <fieldset class="well caixa-fieldset">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Perfil:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="nm_perfil" id="nm_perfil"
                                               placeholder="Informe o rótulo do perfil (será exibido no perfil)" maxlength="50"
                                               value="<?= isset($arPerfil['nm_perfil']) ? $arPerfil['nm_perfil'] : '' ?>">
                                    </div>
                                </div>
                                <div class="form-group row" >
                                    <label class="col-sm-2 col-form-label">Descrição:</label>
                                    <div class="col-sm-6">
                                        <textarea  class="form-control" name="dsc_perfil" id="dsc_perfil" placeholder="Informe a descrição do perfil" rows="5"><?= isset($arPerfil['dsc_perfil']) ? $arPerfil['dsc_perfil'] : '' ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Nível:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="id_nivel" id="id_nivel"
                                               placeholder="Informe o nível do perfil" maxlength="50"
                                               value="<?= isset($arPerfil['id_nivel']) ? $arPerfil['id_nivel'] : '' ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label">
                                        <label>* Ativo?</label>
                                    </div>
                                    <div class="col-sm-2 text-left">
                                        <label class="radio-inline"><input name="st_perfil" type="radio"
                                                                           value="1" <?=isset($arPerfil['st_perfil']) && ($arPerfil['st_perfil'] == 1) ||  !isset($arPerfil['st_perfil']) ? 'checked' : '' ?>> Sim</label>
                                        <label class="radio-inline"><input name="st_perfil" type="radio"
                                                                           value="0" <?=isset($arPerfil['st_perfil']) && ($arPerfil['st_perfil'] == 0) ? 'checked' : '' ?>> Não</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8 text-left  col-sm-offset-2">
                                        <input type="button" class="btn btn-danger btn-novo" value="Limpar">
                                        <input type="submit" class="btn btn-success" name="btn-salvar"
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
<script type="text/javascript" src="<?=HOME_URI."assets/js/manter.perfil.js"?>"></script>
</body>
</html>