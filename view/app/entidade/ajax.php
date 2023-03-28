<?php
require_once '../../config.php';
$entidadeController = new EntidadeController();
$arrPost = ($_POST) ? $_POST : array();

if (isset($_REQUEST['ajax']) && $_REQUEST['ajax']) {
    switch ($_REQUEST['ajax']) {
        case 'get':
            echo json_encode( $entidadeController->get($arrPost['id_entidade'] ) );
            break;
        case 'inativar':
            echo $entidadeController->inativarAtivar($arrPost['id_entidade']);
            break;
        case 'salvar':
            echo $entidadeController->salvar($arrPost);
            break;
        default:
            echo 'Ação ajax não encontrada';
            break;
    }
    exit;
}