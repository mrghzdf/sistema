<?php
ini_set('max_execution_time', 480); // 480 segundos = 8 minutos

// Caminho para a raiz
define( 'APPRAIZ',  str_replace('\\', '/', dirname( dirname(__FILE__ ) ) ));

// Caminho para a pasta de uploads
define( 'UP_ABSPATH', str_replace('adm', '', APPRAIZ) . 'img/_uploads' );

// Charset da conexão PDO
define( 'DB_CHARSET', 'utf8' );

//define( 'HOME_URI', 'http://opontosite.com.br/sistema/view/' ); // PROD
//define( 'HOME_URI_SITE', 'http://opontosite.com.br/sistema/' ); // PROD
//define( 'URLFOTO', 'http://opontosite.com.br/sistema/adm/public/img/' ); // PROD
//define( 'HOSTNAME', 'localhost' ); // PROD
//define( 'DB_USER', 'root' ); // PROD
//define( 'DB_PASSWORD', 'teste' ); // PROD

define( 'HOME_URI', 'http://localhost/opontosite/sistema/view/' ); // LOCAL
define( 'HOME_URI_SITE', 'http://localhost/opontosite/' ); // LOCAL
define( 'URLFOTO', 'http://localhost/opontosite/sistema/public/img/' ); // LOCAL
define( 'HOSTNAME', 'localhost' ); // LOCAL
define( 'DB_USER', 'root' ); // LOCAL
define( 'DB_PASSWORD', '' ); // LOCAL

// Nome do DB
define( 'DB_NAME', 'fbb_sistema' );

// Drive de conexão
define( 'DRIVER_NAME', 'mysql' ); // mysql, oci, pgsql

// Perfil de usuário
define('PFLCOD_DESENV', 1);
define('PFLCOD_ADM', 2);
define('PFLCOD_OPERADOR', 3);

// Se você estiver desenvolvendo, modifique o valor para true
define( 'DEBUG', false );

/**
 * Não edite daqui em diante
 */

// Carrega o loader, que vai carregar a aplicação inteira
require_once APPRAIZ . '/view/loader.php';