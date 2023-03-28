<?php
require_once '../../../config.php';

$menuController = new MenuController();
$arrPost = ($_POST) ? $_POST : array();

if (isset($_REQUEST['ajax']) && $_REQUEST['ajax']) {
    switch ($_REQUEST['ajax']) {

        case 'get':
            $arPagMenu = $menuController->get($arrPost['id_pg_menu']);
            echo json_encode($arPagMenu);
            break;

        case 'inativar':
            echo $menuController->inativarAtivar($arrPost['id']);
            break;

        case 'salvar':
            echo $menuController->salvar($arrPost);
            break;

        default:
            echo 'Ação ajax não encontrada';
            break;

    }
    exit;
}