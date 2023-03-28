<?php
require_once 'view/config.php';

# Requisicoes via POST.
$arrPost = ($_POST) ? $_POST : [];
if ($arrPost) {
    $loginController = new LoginController();
    $loginController->userLogin($arrPost);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text\html; charset=UTF-8">
    <title>FBB - Sistema</title>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= HOME_URI . "assets/css/bootstrap.min.css" ?>" rel="stylesheet">
    <link href="<?= HOME_URI . "assets/css/global.css" ?>" rel="stylesheet" media="screen">
    <link href="<?= HOME_URI . "assets/img/favicon.ico" ?>" rel="Shortcut Icon">
    <link href="<?= HOME_URI . "vendor/jquery-validation-1.16.0/jquery-validation.css" ?>" rel="stylesheet">
    <!-- custom src -->
    <link href="<?= HOME_URI . "assets/css/login.css" ?>" rel="stylesheet" media="screen">
</head>
<body>
<div id="pai">

    <div class="container h-100">
        <div class="row justify-content-center align-items-center mt-10">
            <div class="col-7 caixa-texto">
                <div class="row nopadding" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;">
                    <img src="<?= HOME_URI . "assets/images/fundo-cabecalho.png" ?>" width="100%">
                </div>
                <div class="row justify-content-center align-items-center mt-5">
                    <div class="col-8">
                        <form id="formLogin" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <div>
                                    <input class="form-control" name="nm_login" placeholder="Login" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <input type="password" class="form-control" name="senha" value=""
                                           placeholder="Senha">
                                </div>
                            </div>
                            <div class="form-group login text-center">
                                <div class="dir">
                                    <button type="submit" class="btn btn-primary">ACESSAR</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copy">
        <p>FBB - <span>Fundação Banco do Brasil</span><br>
            <span>SCES, Trecho 02, lote 22 | CEP: 70200-002</span><br>
            Copyright © <?= date('Y') ?> todos os direitos reservados.
        </p>
    </div>
</div>
</body>
</html>