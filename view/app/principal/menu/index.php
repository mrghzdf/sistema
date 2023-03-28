<?php
require_once '../../../config.php';
$menuController = new MenuController();
?>
<?php require_once APPRAIZ . '/view/template/header.inc'; ?>

<div class="container-fluid text-center" style="margin: 0px; ">
    <div class="page-header">
        <h1 class="_ff-m">Menus</h1>
    </div>
    <!-- Form principal -->
    <div class="row">
        <div class="div-legenda-fieldset col-md-offset-4">Dados do menu</div>
        <fieldset class="well col-md-4 col-md-offset-4">
            <form id="frmPagMenu" class="form" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>"
                  enctype="multipart/form-data">
                <input type="hidden" name="id_pg_menu" id="id_pg_menu" value="">
                <div class="form-group">
                    <label>* Nome:</label>
                    <input type="text" class="form-control" name="nm_pg_menu" id='nm_pg_menu' maxlength="20" required="required">
                </div>

                <div class="form-group">
                    <label>Ícone:</label>
                    <input type="text" class="form-control" name="nm_image" id="nm_image" value=""
                           placeholder="Indique o nome do icone/imagem">
                </div>
                <div class="form-group row">
                    <label>* Ordem:</label>
                    <input type="number" min="1" step="1" max="20" class="form-control" name="nr_ordem" id='nr_ordem'
                           placeholder="Informe a ordem do menu" required="required">
                </div>
                <div class="form-group row">
                    <label>Página</label>
                    <select id="id_pagina" name="id_pagina" class="chosen-select form-control">
                        <option value=""> -- Selecione</option>
                        <?php
                        $arDados = $menuController->listPagina();
                        foreach ($arDados as $valor):
                            ?>
                            <option value="<?= $valor['id_pagina'] ?>"><?= $valor['nm_pagina']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group urlExterna">
                    <label>URL externa:</label>
                    <input type="text" class="form-control" name="url_externa" id='url_externa' maxlength="255">
                </div>

                <div class="form-group row">
                    <label>* Visível</label>
                    <select class="form-control" name="st_visivel" id="st_visivel" required="required">
                        <option value="" selected="selected">-- Selecione</option>
                        <option value="1" selected>Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label>* Home</label>
                    <select class="form-control" name="st_home" id="st_home" required="required">
                        <option value="" selected="selected">-- Selecione</option>
                        <option value="1">Sim</option>
                        <option value="0" selected>Não</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" name="limpar" id="limpar" class="btn btn-default">Limpar</button>
                    <button type="submit" name="btn-cadastrar" id="btn-cadastrar" class="btn btn-default">Salvar</button>
                </div>
            </form>
        </fieldset>
    </div>

    <div class="row">
        <h3 class="_ff-m">Listagem</h3>
        <table class="table table-striped table-bordered table-condensed " id="listaDataTable" style="width:100%">
            <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Imagem</th>
                <th scope="col">Ordem</th>
                <th scope="col">Página</th>
                <th scope="col">Visível</th>
                <th scope="col">Home</th>
                <th scope="col">Status</th>
                <th>Editar</th>
                <th>Inativar / Ativar</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<?php include APPRAIZ . '/view/template/footer.inc'; ?>
<script type="text/javascript" src="<?= HOME_URI . "assets/js/manter.pagina.menu.js" ?>"></script>

</body>
</html>