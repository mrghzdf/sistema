<?php
if ( ! defined('APPRAIZ')) exit;

// Inicia a sessão
if(!isset($_SESSION)){session_start();}

// Verifica o modo para debugar
if ( ! defined('DEBUG') || DEBUG === false ) {

    // Esconde todos os erros
    error_reporting(0);
    ini_set("display_errors", 0);

} else {

    // Mostra todos os erros
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

// Carrega todas as controllers dinamicamente
function __autoload($class_name)
{
    $arCaminho = array(
        APPRAIZ . "/controller/",
    );
    foreach ($arCaminho as $caminho) {
        $arquivo = $caminho . $class_name . '.class.inc';

        if (file_exists($arquivo)) {
            require_once($arquivo);
            break;
        }
    }
}

// Conexão e funções globais
require_once APPRAIZ . '/model/conexao.php';
require_once APPRAIZ . '/view/functions/global-functions.php';

validaAcessoMenu();