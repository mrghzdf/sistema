<?php
/**
 * Verifica permissão de acesso ao menu.
 */
function validaAcessoMenu()
{
    if (strpos($_SERVER['REQUEST_URI'], 'app')) {
        checaSessao();
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if (!in_array_recursivo($actual_link, $_SESSION['arMenus']) && empty($_REQUEST)) {
            destroeSessao();
        }

    } else {
        session_destroy();
    }
}

/** Gera senha aleatória de acordo com os parâmetros informados
 * @param int $tamanho
 * @param bool $maiusculas
 * @param bool $numeros
 * @param bool $simbolos
 * @return string
 */
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    $retorno = '';
    $caracteres = '';
    $caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
    if ($numeros) $caracteres .= $num;
    if ($simbolos) $caracteres .= $simb;
    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand - 1];
    }
    return $retorno;
}

function split_name($name)
{
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
    return array($first_name, $last_name);
}

function checaSessao()
{
    if (!$_SESSION["id_usuario"]) {
        destroeSessao();
    }
}

function destroeSessao()
{
    if ($_SESSION["id_usuario"]) {
        session_unset();
        session_destroy();
        header('Location:' . HOME_URI);

    } else {
        header('Location:' . HOME_URI);
    }
}

/**
 * @param $data 00-00-0000
 */
function addDaysDate($data, $dias = 45)
{
    if (!$data) {
        $retorno = '';
    } else {
        $Date = $data;
        return date('d-m-Y', strtotime($Date . ' + ' . $dias . ' days'));
    }
}

/** Cálcula a diferença de data entre a data informada até a data atual
 * @param $data 00-00-0000
 */
function calculaDiffDataAtual($data)
{
    if (!$data) {
        $arRetorno = '';
    } else {
        $data1 = new DateTime($data);
        $data2 = new DateTime(date('d-m-Y'));
        $intervalo = $data1->diff($data2);

        $arRetorno = [];
        $arRetorno['anos'] = $intervalo->y;
        $arRetorno['meses'] = $intervalo->m;
        $arRetorno['dias'] = $intervalo->d;
    }
    return $arRetorno;
}

/**
 * @param $data
 * @param string $padrao d-m-Y ou Y-m-d
 * @return string
 */
function addHifenStringData($data, $padrao = 'd-m-Y')
{

    if (!$data) {
        $clo_date = '';

    } else {
        $data = str_pad($data, 8, '0', STR_PAD_LEFT);

        if ($padrao == 'd-m-Y') {
            preg_match('/(\d{2})(\d{2})(\d{4})/', $data, $matches);
        } else {
            preg_match('/(\d{4})(\d{2})(\d{2})/', $data, $matches);
        }
        unset($matches[0]);
        $clo_date = implode('-', $matches);
    }
    return $clo_date;
}

function somenteNumero($s)
{
    return preg_replace('/\D/', '', $s);
}

/**
 * @param array $arrEmailDestino - array com endereços de email ex: array('email1@dominio.com', 'email2@dominio.com');
 * @param null $htmlCorpo - html que ficará contido no corpo do email
 * @param null $assunto
 */
function enviarEmail($destinatario, $htmlCorpo = null, $assunto = null)
{
    require_once 'constantes.php';
    include_once APPRAIZ . 'vendor/phpmailer/class.smtp.php';
    include_once APPRAIZ . 'vendor/phpmailer/class.phpmailer.php';

    # Dispara e-mail
    $email = new PHPMailer();
    $email->IsHTML(true);
    $email->IsSMTP(true);
    $email->AddAddress($destinatario);
    $email->Subject = $assunto;
    $email->Body = $htmlCorpo;
    return ($email->Send()) ? true : false;
}

function getRealIpAddr()
{

    if ($_SERVER["SERVER_ADDR"] == '::1' || $_SERVER["SERVER_ADDR"] == '127.0.0.1') {
        $localIP = getHostByName(getHostName());
        return $localIP;
    }
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function removeAcento($string)
{
    return preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $string));
}

function in_array_recursivo($paramPesq, $arr, $estrito = false)
{
    foreach ($arr as $item) {
        if (($estrito ? $item === $paramPesq : $item == $paramPesq) || (is_array($item) && in_array_recursivo($paramPesq, $item, $estrito))) {
            return true;
        }
    }
    return false;
}

/**
 * functionName multiImplode
 * @author Djalma Aguiar Rodrigues
 *
 * @param integer $glue (separador)
 * @param array $array (array multidimensional a ser implodido)
 *
 * @return Retorna o implode para o array multidimensional.
 * Interessante para montar um conjunto em consultas SQL. Ex: IN( 1,2,3 )
 *
 * @version v1
 */
function multiImplode($glue, $array)
{
    $ret = '';
    foreach ($array as $item) {
        if (is_array($item)) {
            $ret .= multiImplode($glue, $item) . $glue;
        } else {
            $ret .= $item . $glue;
        }
    }
    $ret = substr($ret, 0, 0 - strlen($glue));
    return $ret;
}

function geraCodigoBarra($numero)
{
    $fino = 1;
    $largo = 3;
    $altura = 17;

    $barcodes[0] = '00110';
    $barcodes[1] = '10001';
    $barcodes[2] = '01001';
    $barcodes[3] = '11000';
    $barcodes[4] = '00101';
    $barcodes[5] = '10100';
    $barcodes[6] = '01100';
    $barcodes[7] = '00011';
    $barcodes[8] = '10010';
    $barcodes[9] = '01010';

    for ($f1 = 9; $f1 >= 0; $f1--) {
        for ($f2 = 9; $f2 >= 0; $f2--) {
            $f = ($f1 * 10) + $f2;
            $texto = '';
            for ($i = 1; $i < 6; $i++) {
                $texto .= substr($barcodes[$f1], ($i - 1), 1) . substr($barcodes[$f2], ($i - 1), 1);
            }
            $barcodes[$f] = $texto;
        }
    }

    $imgPgif = APPRAIZ . '/view/images/p.gif';
    $imgBgif = APPRAIZ . '/view/images/b.gif';
    $retorno = '';

    $retorno .= '<img src="' . $imgPgif . '" width="' . $fino . '" height="' . $altura . '" border="0" />';
    $retorno .= '<img src="' . $imgBgif . '" width="' . $fino . '" height="' . $altura . '" border="0" />';
    $retorno .= '<img src="' . $imgPgif . '" width="' . $fino . '" height="' . $altura . '" border="0" />';
    $retorno .= '<img src="' . $imgBgif . '" width="' . $fino . '" height="' . $altura . '" border="0" />';

    $retorno .= '<img ';

    $texto = $numero;

    if ((strlen($texto) % 2) <> 0) {
        $texto = '0' . $texto;
    }

    while (strlen($texto) > 0) {
        $i = round(substr($texto, 0, 2));
        $texto = substr($texto, strlen($texto) - (strlen($texto) - 2), (strlen($texto) - 2));

        if (isset($barcodes[$i])) {
            $f = $barcodes[$i];
        }

        for ($i = 1; $i < 11; $i += 2) {
            if (substr($f, ($i - 1), 1) == '0') {
                $f1 = $fino;
            } else {
                $f1 = $largo;
            }

            $retorno .= 'src="' . $imgPgif . '"width="' . $f1 . '" height="' . $altura . '" border="0">';
            $retorno .= '<img ';

            if (substr($f, $i, 1) == '0') {
                $f2 = $fino;
            } else {
                $f2 = $largo;
            }

            $retorno .= 'src="' . $imgBgif . '" width="' . $f2 . '" height="' . $altura . '" border="0">';
            $retorno .= '<img ';
        }
    }
    $retorno .= 'src="' . $imgPgif . '" width="' . $largo . '" height="' . $altura . '" border="0" />';
    $retorno .= '<img src="' . $imgBgif . '" width="' . $fino . '" height="' . $altura . '" border="0" />';
    $retorno .= '<img src="' . $imgPgif . '" width="1" height="' . $altura . '" border="0" />';
    $retorno .= '<br>' . $numero;

    return $retorno;
}

function saudacao($nome = '')
{
    date_default_timezone_set('America/Sao_Paulo');
    $hora = date('H');
    if ($hora >= 6 && $hora <= 12)
        return 'Bom dia' . (empty($nome) ? '' : ', ' . $nome);
    else if ($hora > 12 && $hora <= 18)
        return 'Boa tarde' . (empty($nome) ? '' : ', ' . $nome);
    else
        return 'Boa noite' . (empty($nome) ? '' : ', ' . $nome);
}

function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
            $item = utf8_encode($item);
        }
    });

    return $array;
}

function dataready($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function array_flatten($array)
{
    $result = [];
    foreach ($array as $element) {
        if (is_array($element)) {
            $result = array_merge($result, array_flatten($element));
        } else {
            $result[] = $element;
        }
    }
    return $result;
}