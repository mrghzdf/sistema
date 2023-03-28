<?php
require_once '../../config.php';
$cisternaController = new CisternaController();
$arrPost = ($_POST) ? $_POST : array();

if (isset($_REQUEST['ajax']) && $_REQUEST['ajax']) {
    switch ($_REQUEST['ajax']) {
        case 'get':
            echo json_encode($cisternaController->get($arrPost['id_cisterna']));
            break;
        case 'inativar':
            echo $cisternaController->inativarAtivar($arrPost['id_cisterna']);
            break;
        case 'salvar':
            echo $cisternaController->salvar($arrPost);
            break;
        default:
            echo 'Ação ajax não encontrada';
            break;
    }
    exit;
}