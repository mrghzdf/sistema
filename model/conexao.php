<?php
/**
 * Conexao - Classe para gerenciamento da base de dados
 *
 * @package TutsupMVC
 * @since 0.1
 */
class Conexao
{
    /** DB properties */
    public $host      = HOSTNAME,     // Host da base de dados
           $db_name   = DB_NAME,      // Nome do banco de dados
           $password  = DB_PASSWORD,  // Senha do usuário da base de dados
           $user      = DB_USER,      // Usuário da base de dados
           $charset   = DB_CHARSET,   // Charset da base de dados
           $drive     = DRIVER_NAME,  // Driver de conexão
           $pdo       = null,         // Nossa conexão com o BD
           $error     = null,         // Configura o erro
           $debug     = false,        // Mostra todos os erros
           $last_id   = null;         // Último ID inserido

    /**
     * Construtor da classe
     *
     * @since 0.1
     * @access public
     * @param string $host
     * @param string $db_name
     * @param string $password
     * @param string $user
     * @param string $charset
     * @param string $debug
     */
    public function __construct(
        $host     = null,
        $db_name  = null,
        $password = null,
        $user     = null,
        $charset  = null,
        $debug    = null,
        $drive    = null
    ) {

        // Configura as propriedades novamente.
        // Se você fez isso no início dessa classe, as constantes não serão
        // necessárias. Você escolhe...
        $this->host     = defined( 'HOSTNAME'    ) ? HOSTNAME    : $this->host;
        $this->db_name  = defined( 'DB_NAME'     ) ? DB_NAME     : $this->db_name;
        $this->password = defined( 'DB_PASSWORD' ) ? DB_PASSWORD : $this->password;
        $this->user     = defined( 'DB_USER'     ) ? DB_USER     : $this->user;
        $this->charset  = defined( 'DB_CHARSET'  ) ? DB_CHARSET  : $this->charset;
        $this->debug    = defined( 'DEBUG'       ) ? DEBUG       : $this->debug;
        $this->drive    = defined( 'DRIVER_NAME' ) ? DRIVER_NAME : $this->drive;

        // Conecta
        $this->connect();

    } // __construct

    /**
     * Cria a conexão PDO
     *
     * @since 0.1
     * @final
     * @access protected
     */
    final protected function connect() {

        /* Os detalhes da nossa conexão PDO */
        $pdo_details  = $this->drive.":host={$this->host};";
        $pdo_details .= "dbname={$this->db_name};";
        $pdo_details .= "charset={$this->charset};";

        // Tenta conectar
        try {
            $this->pdo = new PDO($pdo_details, $this->user, $this->password);

            // Verifica se devemos debugar
            if ( $this->debug === true ) {

                // Configura o PDO ERROR MODE
                $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

            }

            // Não precisamos mais dessas propriedades
            unset( $this->host     );
            unset( $this->db_name  );
            unset( $this->password );
            unset( $this->user     );
            unset( $this->charset  );

        } catch (PDOException $e) {

            // Verifica se devemos debugar
            if ( $this->debug === true ) {

                // Mostra a mensagem de erro
                echo "Erro: " . $e->getMessage();

            }

            // Kills the script
            die();
        } // catch
    } // connect

    /**
     * query - Consulta PDO
     *
     * @since 0.1
     * @access public
     * @return object|bool Retorna a consulta ou falso
     */
    public function query( $stmt, $data_array = null ) {

        // Prepara e executa
        $query      = $this->pdo->prepare( $stmt );
        $check_exec = $query->execute( $data_array );

        // Verifica se a consulta aconteceu
        if ( $check_exec ) {

            // Retorna a consulta
            return $query;

        } else {

            // Configura o erro
            $error       = $query->errorInfo();
            $this->error = $error[2];

            // Retorna falso
            return false;

        }
    }

    function insere($sql)
    {
        try {
            if ($this->query($sql)) {
                return $this->pdo->lastInsertId();
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

    function executar($sql)
    {
        try {
            if ($this->query($sql)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

    function pegaUm($sql)
    {
        try {
            $res = $this->query($sql)->fetchColumn();
            return $res;
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

    function pegaLinha($sql)
    {
        try {
            $res = $this->query($sql)->fetch();
            return $res;
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

    function carregar($sql)
    {
        try {
            $sth = $this->pdo->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
    }

    public function fecharConexao()
    {
        $this->pdo = null;
    }

}