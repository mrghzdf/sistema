<?php
require_once '../../config.php';
$entidadeController = new EntidadeController();
$tipoConstrucaoController = new TipoConstrucaoController();
$paisController = new PaisController();
$estadoController = new EstadoController();
$cidadeController = new CidadeController();
?>
<?php require_once APPRAIZ . '/view/template/header.inc'; ?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Cadastro de Cisterna</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="container-fluid text-center">
    <div class="row justify-content-center align-items-center cadastro mt-2">
        <div class="col-12">
            <form id="frmCisterna" class="form text-left" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>"
                  enctype="multipart/form-data">
                <input type="hidden" name="id_cisterna" id="id_cisterna">
                <div class="div-legenda-fieldset">Dados da Cisterna</div>
                <fieldset class="well caixa-fieldset">
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* Entidade Mantenedora:</label>
                        <div class="col-8">
                            <select id="fk_id_entidade" name="fk_id_entidade" class="form-control" required>
                                <option value=""> -- Selecione</option>
                                <?php
                                foreach ($entidadeController->listEntidade() as $valor):
                                    ?>
                                    <option value="<?= $valor['id_entidade'] ?>"><?= $valor['nm_fantasia'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* Tipo de Construção:</label>
                        <div class="col-8">
                            <select id="fk_id_tp_construcao" name="fk_id_tp_construcao" class="form-control" required>
                                <option value=""> -- Selecione</option>
                                <?php
                                foreach ($tipoConstrucaoController->listAll() as $valor):
                                    ?>
                                    <option value="<?= $valor['id_tp_construcao'] ?>"><?= $valor['nm_tp_construcao'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* Materiais utilizado:</label>
                        <div class="col-8">
                            <textarea class="form-control" name="dsc_materiais"
                                      placeholder="Informe quais materiais foram utilizados na construção"
                                      id="dsc_materiais" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Data de Inauguração:</label>
                        <div class="col-8">
                            <input type="datetime-local" class="form-control" name="dt_inauguracao" id="dt_inauguracao"
                                   placeholder="Informe a data de inauguração" maxlength="20" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* País:</label>
                        <div class="col-8">
                            <select id="fk_id_pais" name="fk_id_pais" class="chosen-select form-control">
                                <option value=""> -- Selecione</option>
                                <?php
                                foreach ($paisController->listAll() as $valor):
                                    ?>
                                    <option value="<?= $valor['id_pais'] ?>"><?= $valor['nome_pt'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* Estado:</label>
                        <div class="col-8">
                            <select id="fk_id_estado" name="fk_id_estado" class="chosen-select form-control">
                                <option value=""> -- Selecione</option>
                                <?php
                                foreach ($estadoController->listAll() as $valor):
                                    ?>
                                    <option value="<?= $valor['id_estado'] ?>"><?=$valor['uf'] .' - '. $valor['nome'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* Cidade:</label>
                        <div class="col-8">
                            <select id="fk_id_cidade" name="fk_id_cidade" class="chosen-select form-control">
                                <option value=""> -- Selecione</option>
                                <?php
                                foreach ($cidadeController->listAll() as $valor):
                                    ?>
                                    <option value="<?= $valor['id_cidade'] ?>"><?= $valor['nome'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* Bairro:</label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="nm_bairro" id="nm_bairro"
                                   placeholder="Informe o Bairro" maxlength="100" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* Endereço:</label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="nm_endereco" id="nm_endereco"
                                   placeholder="Informe o endereço" maxlength="60" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Latitude:</label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="nr_latitude" id="nr_latitude"
                                   placeholder="Para maior precisão do Google Maps, por favor a latitude (opicional). Exemplo: -15.77952200"
                                   value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Longitude:</label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="nr_longitude" id="nr_longitude"
                                   placeholder="Para maior precisão do Google Maps, por favor a longitude (opicional). Exemplo: -47.92965700"
                                   value="">
                        </div>
                    </div>

                    <div id="infoMapa" class="p-3 mb-2 bg-light text-dark text-center">Mapa será exibido aqui após inclusão do endereço ou latitude / longitude.</div>

                    <div class="form-group row mt-4 geolocalizacao" style="display: none">
                        <div class="col-12 justify-content-center align-items-center text-center">
                            <h3>Localização</h3>
                            <div id="mapaGoogle"></div>
                        </div>
                    </div>

                    <div class="form-group row col-md-offset-2">
                        <div class="col-sm-10">
                            <input type="button" class="btn btn-danger btn-novo" value="Limpar">
                            <input type="submit" class="btn btn-success" name="btn-salvar"
                                   id="btn-salvar"
                                   value="Salvar">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="row">
        <h3 class="_ff-m">Listagem</h3>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered table-condensed" id="listaDataTable" style="width:100%">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Entidade Mantenedora</th>
                <th scope="col">Tipo de Construção</th>
                <th scope="col">Materiais utilizados</th>
                <th scope="col">País</th>
                <th scope="col">Estado</th>
                <th scope="col">Cidade</th>
                <th scope="col">Bairro</th>
                <th scope="col">Endereço</th>
                <th scope="col">Data de Inauguração</th>
                <th scope="col">Status</th>
                <th scope="col">Data de Cadastro</th>
                <th>Editar</th>
                <th>Inativar / Ativar</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<?php include APPRAIZ . '/view/template/footer.inc'; ?>
<script type="text/javascript" src="<?= HOME_URI . "assets/js/manter.cisterna.js" ?>"></script>

</body>
</html>