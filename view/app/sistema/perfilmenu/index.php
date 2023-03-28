<?php
require_once '../../../config.php';

# Classes
$conexao = new Conexao();

# Requisicao GET de AJAX - Verificando se tem requisicao ajax, se tiver chama a funcao e finaliza a pagina.
if (isset($_REQUEST['ajax']) && $_REQUEST['ajax']) {
    switch ($_REQUEST['ajax']) {
        case 'salvarPerfilMenu':

            // Deleta antigos
            $sql = "DELETE FROM fbb_sistema.tbl_perfil_menu WHERE id_perfil = {$_REQUEST['id_perfil']}";
            $conexao->executar($sql);

            // Adiciona novos
            foreach ($_REQUEST['url_menu'] as $valor) {
                $sql = "INSERT
                            INTO
                                `fbb_sistema`.`tbl_perfil_menu`
                                (
                                    `id_perfil`,
                                    `id_menu`
                                )
                                VALUES
                                (
                                    '{$_REQUEST['id_perfil']}',
                                   '{$valor}'
                                );
                            ";
                $conexao->executar($sql);
            }

            // Adiciona o menu Home caso o usuário não tenha adicionado. Obrigatória para todos os perfis
            $sql = "INSERT
                    INTO
                        `fbb_sistema`.`tbl_perfil_menu`
                        (
                            `id_perfil`,
                            `id_menu`
                        )
                      SELECT '{$_REQUEST['id_perfil']}', id_menu 
                      FROM fbb_sistema.tbl_menu 
                      WHERE id_menu 
                      NOT IN( SELECT id_menu FROM fbb_sistema.tbl_perfil_menu 
                      WHERE id_perfil =  '{$_REQUEST['id_perfil']}' ) and is_pag_inicial = true
                      LIMIT 1
                    ";
            $conexao->executar($sql);
            echo true;
            break;
        default:
            echo 'Ação ajax não encontrada';
            break;
    }
    exit;
}

# Alteração
if (isset($_GET['acao']) && $_GET['acao'] === 'A') {
    if ($_REQUEST['id_perfil']) {
        $arPerfil = $conexao->pegaLinha("SELECT * FROM fbb_sistema.tbl_perfil WHERE id_perfil = '{$_REQUEST['id_perfil']}'");
    }
# Inclusão
} else {
    $arPerfil = array();
}

// Lista
$sql = "SELECT * FROM fbb_sistema.tbl_perfil where st_perfil = 1 ORDER BY id_nivel";
$arDados = $conexao->carregar($sql);
$totalRegistros = sizeof($arDados);
?>
<?php require_once APPRAIZ . '/view/template/header.inc'; ?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Vincular menu ao perfil</h4>
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
                            <td><?= $strValue['st_perfil'] == 1 ? 'Ativo' : 'Inativo' ?></td>
                            <td>
                                <div align="center">
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
                <div class="row cadastro"
                     style="margin-top: 20px; <?= isset($_REQUEST['acao']) && $_REQUEST['acao'] == 'A' ? '' : 'display: none;' ?>">
                    <div class="col-md-12">
                        <h2 class="h2-titulo">Alterar perfil x menu</h2>
                        <form id="frmPerfilMenu" class="form text-left" method="post"
                              action="<?= $_SERVER['REQUEST_URI'] ?>"
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
                                               placeholder="Informe o rótulo do perfil (será exibido no perfil)"
                                               maxlength="50"
                                               value="<?= isset($arPerfil['nm_perfil']) ? $arPerfil['nm_perfil'] : '' ?>"
                                               readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Lista de menus:</label>
                                    <div class="col-sm-10">
                                        <select id="second" name="url_menu[]" multiple="multiple" size="5"
                                                class="chosen-select"
                                                data-placeholder="Selecione os menus deste perfil">
                                            <?php
                                            // Todos os menus ativos
                                            $sql = "SELECT menu.*,
                                                        COALESCE( ( select m.nm_menu from 
                                                        `fbb_sistema`.`tbl_menu` m where m.id_menu = menu.id_menu_pai ), 'Raiz') as menu_pai
                                                    FROM `fbb_sistema`.`tbl_menu` menu 
                                                    Where menu.st_menu = 1 ORDER BY menu.id_menu_pai, menu.nro_ordem";
                                            $arDados = $conexao->carregar($sql);

                                            // Menus do perfil informado
                                            $sql = "SELECT id_menu FROM `fbb_sistema`.`tbl_perfil_menu` Where id_perfil = {$_REQUEST['id_perfil']} ORDER BY id_menu";
                                            $arPerfilMenu = $conexao->carregar($sql);

                                            foreach ($arDados as $strKey => $strValue) {
                                                if (!empty($arPerfilMenu)) {
                                                    if (in_array_recursivo($strValue['id_menu'], $arPerfilMenu)) {
                                                        $selected = 'selected="selected "';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                }
                                                echo '<option value="' . $strValue['id_menu'] . '" ' . $selected . '>' . $strValue['nm_menu'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <button type="button" class="chosen-toggle select btn btn-success">Selecionar
                                            todos
                                        </button>
                                        <button type="button" class="chosen-toggle deselect btn btn-danger">Retirar
                                            todos
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row col-md-offset-2">
                                    <div class="col-10">
                                        <input type="submit" class="btn btn-success" name="btn-salvar"
                                               id="btn-salvar"
                                               value="Salvar">
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
<script type="text/javascript" src="<?= HOME_URI . "assets/js/manter.perfil.menu.js" ?>"></script>
</body>
</html>