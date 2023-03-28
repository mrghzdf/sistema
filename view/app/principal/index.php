<?php require_once '../../config.php';?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once APPRAIZ . '/view/template/header.inc'; ?>
</head>
<body>
<?php include APPRAIZ . '/view/template/menu.inc'; ?>
<div class="container-fluid text-center">
    <div class="page-header">
        <h3>Área Administrativa FBB</h3>
    </div>
    <p style="font-size: 14px"><?= saudacao($_SESSION["nm_login"]) ?>!</p>
    <p style="font-size: 14px">Seu último acesso foi em <?= $_SESSION["ultimo_acesso"] ?>.</p>
</div>
<?php include APPRAIZ . '/view/template/footer.inc'; ?>
</body>
</html>