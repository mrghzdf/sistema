<?php
require_once '../../config.php';
$entidadeController = new EntidadeController();
$paisController = new PaisController();
$estadoController = new EstadoController();
$cidadeController = new CidadeController();
$cisternaController = new CisternaController();
?>
<?php require_once APPRAIZ . '/view/template/header.inc'; ?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Entidade Mantenedora</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="container-fluid text-center">
    <div class="row justify-content-center align-items-center cadastro mt-2">
        <div class="col-12">
            <form id="frmEntidade" class="form text-left" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>"
                  enctype="multipart/form-data">
                <input type="hidden" name="id_entidade" id="id_entidade">
                <input type="hidden" name="url_home" id="url_home" VALUE="<?= HOME_URI ?>">

                <div class="div-legenda-fieldset">Dados da entidade</div>

                <fieldset class="well caixa-fieldset">
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* Nome fantasia:</label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="nm_fantasia" id="nm_fantasia"
                                   placeholder="Nome fantasia" maxlength="100" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* CNPJ:</label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="nr_cnpj" id="nr_cnpj"
                                   placeholder="Informe o CNPJ com 14 números" maxlength="14" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* País:</label>
                        <div class="col-8">
                            <select id="fk_id_pais" name="fk_id_pais" class="chosen-select form-control" required>
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
                            <select id="fk_id_estado" name="fk_id_estado" class="chosen-select form-control" required>
                                <option value=""> -- Selecione</option>
                                <?php
                                foreach ($estadoController->listAll() as $valor):
                                    ?>
                                    <option value="<?= $valor['id_estado'] ?>"><?= $valor['uf'] . ' - ' . $valor['nome'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">* Cidade:</label>
                        <div class="col-8">
                            <select id="fk_id_cidade" name="fk_id_cidade" class="chosen-select form-control" required>
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
                        <label class="col-2 col-form-label">* CEP:</label>
                        <div class="col-8">
                            <input type="text" class="form-control" name="nr_cep" id="nr_cep"
                                   placeholder="Informe o CEP com 8 números" maxlength="8" value="" required>
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
                        <label class="col-2 col-form-label">* Telefone:</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" name="nr_ddd" id="nr_ddd" min="11" max="99"
                                   placeholder="DDD" maxlength="2" value="">
                        </div>
                        <div class="col-sm-5">
                            <input type="tel" class="form-control" name="nr_telefone" id="nr_telefone"
                                   placeholder="Informe o telefone" maxlength="10" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Observacao:</label>
                        <div class="col-8">
                            <textarea class="form-control" name="nm_observacao"
                                      placeholder="Informe informações opcionais desta"
                                      id="nm_observacao" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Cisternas vinculadas (manutenção):</label>
                        <div class="col-8">
                            <ul class="list-group" style="list-style-type: none">
                            </ul>
                        </div>
                    </div>

                    <div class="form-group row col-md-offset-2">
                        <div class="col-10">
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
        <div class="col-12">
            <table class="table table-striped table-bordered table-condensed" id="listaDataTable"
                   style="width:100%">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome Fantasia</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">CNPJ</th>
                    <th scope="col">País</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Bairro</th>
                    <th scope="col">Endereco</th>
                    <th scope="col">Cep</th>
                    <th scope="col">Status</th>
                    <th scope="col">Data de Cadastro</th>
                    <th>Editar</th>
                    <th>Inativar / Ativar</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?php include APPRAIZ . '/view/template/footer.inc'; ?>
<script type="text/javascript" src="<?= HOME_URI . "assets/js/manter.entidade.js" ?>"></script>

</body>
</html>