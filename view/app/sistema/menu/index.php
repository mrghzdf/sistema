<?php
require_once '../../../config.php';

# Classes
$conexao = new Conexao();

# Requisicao GET de AJAX - Verificando se tem requisicao ajax, se tiver chama a funcao e finaliza a pagina.
if (isset($_REQUEST['ajax']) && $_REQUEST['ajax']) {

    switch ($_REQUEST['ajax']) {
        case 'salvarMenu':
            $url = $_REQUEST['url_menu'];
            $sql = "SELECT COUNT(id_menu) FROM fbb_sistema.tbl_menu WHERE id_menu = '{$_REQUEST['id_menu']}'";
            $boolExiste = $conexao->pegaUm($sql);
            if ((int)($boolExiste) == 0) {
                $sql = "INSERT
                            INTO
                                `fbb_sistema`.`tbl_menu`
                                (
                                    `url_menu`,
                                    `dsc_menu`,
                                    `st_menu`,
                                    `nm_menu`,
                                    `nro_ordem`
                                )
                                VALUES
                                (
                                   '{$url}',
                                   '{$_REQUEST['dsc_menu']}',
                                   '{$_REQUEST['st_menu']}',
                                   '{$_REQUEST['nm_menu']}',
                                    {$_REQUEST['nro_ordem']}
                                );
                            ";
                echo $conexao->executar($sql);
            } else {
                echo 0;
            }

            break;
        case 'atualizarMenu':
            $url = $_REQUEST['url_menu'];
            $sql = "UPDATE
                        `fbb_sistema`.`tbl_menu`
                    SET
                        `url_menu` = '{$url}',
                        `dsc_menu` = '{$_REQUEST['dsc_menu']}',
                        `st_menu` = '{$_REQUEST['st_menu']}',
                        `nm_menu` = '{$_REQUEST['nm_menu']}',
                        `nro_ordem` = {$_REQUEST['nro_ordem']}
                    WHERE
                        `id_menu` = {$_REQUEST['id_menu']};
                    ";
            echo $conexao->executar($sql);
            break;
        case 'inativarMenu':
            $sql = "UPDATE fbb_sistema.tbl_menu SET st_menu = 0 WHERE id_menu = '{$_REQUEST['id_menu']}';";
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

    if ($_REQUEST['id_menu']) {
        $arMenu = $conexao->pegaLinha("SELECT * FROM fbb_sistema.tbl_menu WHERE id_menu = '{$_REQUEST['id_menu']}'");
    }
# Inclusão
} else {
    $strLabel = 'Incluir';
    $strAviso = 'Incluído';
    $arMenu = array();
}

// Lista
$sql = "SELECT * FROM tbl_menu ORDER BY id_menu_pai, nro_ordem";
$arDados = $conexao->carregar($sql);
$totalRegistros = sizeof($arDados);
?>

<?php require_once APPRAIZ . '/view/template/header.inc'; ?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Menus</h4>
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
                        <th>Rótulo</th>
                        <th>Descrição</th>
                        <th>Ordem</th>
                        <th>Pasta</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($arDados as $strKey => $strValue) {
                        ?>
                        <tr>
                            <td><?= $strValue['id_menu'] ?></td>
                            <td><?= $strValue['nm_menu'] ?></td>
                            <td><?= $strValue['dsc_menu'] ?></td>
                            <td><?= $strValue['nro_ordem'] ?></td>
                            <td><?= $strValue['url_menu'] ?></td>
                            <td><?= $strValue['st_menu'] == 1 ? 'Ativo' : 'Inativo' ?></td>
                            <td>
                                <div align="center">
                                    <?php if (!$strValue['is_pag_inicial']): ?>
                                        <a href="#"><img src="<?= HOME_URI . "assets/images/icones/delete.png" ?>"
                                                         onclick="inativarMenu('<?= $strValue['id_menu'] ?>');"></a>
                                    <?php endif; ?>
                                    <a href="?acao=A&id_menu=<?= $strValue['id_menu'] ?>"><img
                                                src="<?= HOME_URI . "assets/images/icones/application_edit.png" ?>"></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <div class="row d-flex flex-row">
                    <div class="col-12 text-left mt-2">
                        <button type="button" class="btn btn-success btn-novo">
                            <i class="fa fa-plus-circle"></i> Novo
                        </button>
                    </div>
                </div>
                <div class="row justify-content-center align-items-center cadastro"
                     style="margin-top: 20px; <?= isset($_REQUEST['acao']) && $_REQUEST['acao'] == 'A' ? '' : 'display: none;' ?>">
                    <div class="col-12">
                        <h2 class="h2-titulo"><?= $strLabel ?> menu</h2>
                        <form id="frmMenu" class="form text-left" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>"
                              enctype="multipart/form-data">
                            <input type="hidden" name="acao" id="acao" value="<?= $_REQUEST['acao'] ?>"/>
                            <input type="hidden" name="ajax" id="ajax"/>
                            <input type="hidden" name="id_menu" id="id_menu"
                                   value="<?= isset($_REQUEST['id_menu']) ? $_REQUEST['id_menu'] : '' ?>"/>
                            <div class="div-legenda-fieldset">Dados do menu</div>
                            <fieldset class="well caixa-fieldset">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Rótulo:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="nm_menu" id="nm_menu"
                                               placeholder="Informe o rótulo do menu (será exibido no menu)"
                                               maxlength="50"
                                               value="<?= isset($arMenu['nm_menu']) ? $arMenu['nm_menu'] : '' ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Descrição:</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="dsc_menu" id="dsc_menu"
                                                  placeholder="Informe a descrição do menu"
                                                  rows="5"><?= isset($arMenu['dsc_menu']) ? $arMenu['dsc_menu'] : '' ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">* Ordem:</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" name="nro_ordem" id="nro_ordem"
                                               min="1" max="50"
                                               placeholder="Informe a ordem do menu"
                                               value="<?= isset($arMenu['nro_ordem']) ? $arMenu['nro_ordem'] : '1' ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Pasta:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="url_menu" id="url_menu"
                                               placeholder="Informe o nome da pasta contida em (app)." maxlength="50"
                                               value="<?= isset($arMenu['url_menu']) ? str_replace(HOME_URI, '', $arMenu['url_menu']) : '' ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2 col-form-label">
                                        <label>* Ativo?</label>
                                    </div>
                                    <div class="col-sm-2 text-left">
                                        <label class="radio-inline"><input name="st_menu" type="radio"
                                                                           value="1" <?= isset($arMenu['st_menu']) && ($arMenu['st_menu'] == 1) || !isset($arMenu['st_menu']) ? 'checked' : '' ?>>
                                            Sim</label>
                                        <label class="radio-inline"><input name="st_menu" type="radio"
                                                                           value="0" <?= isset($arMenu['st_menu']) && ($arMenu['st_menu'] == 0) ? 'checked' : '' ?>>
                                            Não</label>
                                    </div>
                                </div>

                                <div class="form-group row col-md-offset-2">
                                    <div class="col-sm-10">
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
<script type="text/javascript" src="<?= HOME_URI . "assets/js/manter.menu.js" ?>"></script>
</body>
</html>