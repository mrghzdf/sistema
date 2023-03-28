/*** Instruções para instalação do Framework MVC ***/

1. Habilite as extensões no php.ini
extension=php_mysql.dll
extension=php_pdo_mysql.dll
extension=php_pdo_oci.dll

2. Configurar o vhost
# Virtual host
<VirtualHost *:80>
    DocumentRoot C:\xampp\htdocs\mvc\view
    ServerName meuprojeto.local
</VirtualHost>

3. Incluir no proxy a exeção para: sicadf.local

4. Adicionar no arquivo hosts:
127.0.0.1  			sistema.local

5. Alterar constantes no config.php, conforme desejado
define( 'HOME_URI', 'http://meuprojeto.local/' );
define( 'HOSTNAME', 'localhost' );
define( 'DB_NAME', 'test' );
define( 'DB_USER', 'root' );
define( 'DRIVER_NAME', 'mysql' ); // mysql, oci, pgsql
define( 'DB_PASSWORD', '' );

6. Inclusão de nova página.
a) Adicione uma pasta de referência dentro da pasta app e inclua um arquivo php, conforme exemplo em: app/home/index.php
b) Adicione o arquivo de controller sempre com o sufixo 'Controller' ArquivoController.php. Esse arquivo faz chamadas a model e faz tratativas negociais.
c) Adicione o arquivo de model sempre com o sufixo 'Model' ArquivoModel.php. Esse arquivo é responsável por obter dados da base de dados.
d) Adicione o arquivo de view