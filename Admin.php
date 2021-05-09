<?php defined('crud_mvc') or die; ?>
<?php

class Admin
{
    private $atributos;

    public function __construct()
    {

    }

    public function __set($atributo, $valor)
    {
        $this->atributos[$atributo] = $valor;
        return $this;
    }

    public function __get($atributo)
    {
        return $this->atributos[$atributo];
    }

    public function __isset($atributo)
    {
        return isset($this->atributos[$atributo]);
    }

    public static function findCPFandSenha($cpf, $senha)
    {
        $conexao = Conexao::getInstance();
        $stmt    = $conexao->prepare("SELECT * FROM solicitante WHERE cpf_solicitante = ? and cpf_solicitante = ?;");
        if ($stmt->execute(array($cpf, $senha))) {
            if ($stmt->rowCount() > 0) {
                $resultado = $stmt->fetchAll(PDO::FETCH_CLASS,'Resultado');
                if ($resultado) {
                    return $resultado;
                }
            }
        }
        return array();
    }

    public static function authPortal($usuario, $senha) {
        $conexao = Conexao::getInstance();
        $stmt    = $conexao->prepare("SELECT * FROM usuarios_permitidos WHERE usuario = ? and senha = md5(?)");
        echo " senhas $usuario, $senha";
        if ($stmt->execute(array($usuario, $senha))) {
            if ($stmt->rowCount() > 0) {
                $resultado = $stmt->fetchAll(PDO::FETCH_CLASS,'Admin');
                if ($resultado) {
                    return $resultado;
                }
            }
        }
        return array();
    }

    public function status($id) {
        $conexao = Conexao::getInstance();
        $stmt = $conexao->prepare("UPDATE usuario_acesso SET desativado = IF(desativado is null, true, null) WHERE id = ?");
        if ($stmt->execute(array($id))) {
            return true; 
        }
        return false;
    }

    public function saveUsuarioAcesso()
    {
        $colunas = $this->preparar($this->atributos);
        if (!isset($this->id)) {
            $query = "INSERT INTO usuario_acesso (".
                implode(', ', array_keys($colunas)).
                ") VALUES (".
                implode(', ', array_values($colunas)).");";
        } else {
            foreach ($colunas as $key => $value) {
                if ($key !== 'id') {
                    $definir[] = "{$key}={$value}";
                }
            }
            $query = "UPDATE usuario_acesso SET ".implode(', ', $definir)." WHERE id='{$this->id}';";
        }
        if ($conexao = Conexao::getInstance()) {
            $stmt = $conexao->prepare($query);
            if ($stmt->execute()) {
                return $stmt->rowCount();
            }
        }
        return false;
    }

    /**
     * Salvar o contato
     * @return boolean
     */
    public function save()
    {
        $colunas = $this->preparar($this->atributos);
        if (!isset($this->id)) {
            $query = "INSERT INTO solicitante (".
                implode(', ', array_keys($colunas)).
                ") VALUES (".
                implode(', ', array_values($colunas)).");";
        } else {
            foreach ($colunas as $key => $value) {
                if ($key !== 'id') {
                    $definir[] = "{$key}={$value}";
                }
            }
            $query = "UPDATE solicitante SET ".implode(', ', $definir)." WHERE id='{$this->id}';";
        }
        if ($conexao = Conexao::getInstance()) {
            $stmt = $conexao->prepare($query);
            if ($stmt->execute()) {
                return $stmt->rowCount();
            }
        }
        return false;
    }

    /**
     * Tornar valores aceitos para sintaxe SQL
     * @param type $dados
     * @return string
     */
    private function escapar($dados)
    {
        if (is_string($dados) & !empty($dados)) {
            return "'".addslashes($dados)."'";
        } elseif (is_bool($dados)) {
            return $dados ? 'TRUE' : 'FALSE';
        } elseif ($dados !== '') {
            return $dados;
        } else {
            return 'NULL';
        }
    }

    /**
     * Verifica se dados são próprios para ser salvos
     * @param array $dados
     * @return array
     */
    private function preparar($dados)
    {
        $admin = array();
        foreach ($dados as $k => $v) {
            if (is_scalar($v)) {
                $admin[$k] = $this->escapar($v);
            }
        }
        return $admin;
    }

    public function findCPFUsuarioAcesso($cpf)
    {
        $conexao = Conexao::getInstance();
        $stmt    = $conexao->prepare("SELECT * FROM usuario_acesso where cpf_acesso = ?;");
        $result  = array();

        if ($stmt->execute(array($cpf))) {
            while ($rs = $stmt->fetchObject(Admin::class)) {
                $result[] = $rs;
            }
        }
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    public function findaAllUsuariosPermitidos()
    {
        $conexao = Conexao::getInstance();
        $stmt    = $conexao->prepare("SELECT * FROM usuarios_permitidos;");
        $result  = array();
        if ($stmt->execute()) {
            while ($rs = $stmt->fetchObject(Admin::class)) {
                $result[] = $rs;
            }
        }
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Retornar o número de registros
     * @return int/boolean
     */
    public static function count()
    {
        $conexao = Conexao::getInstance();
        $count   = $conexao->exec("SELECT count(*) FROM solicitante;");
        if ($count) {
            return (int) $count;
        }
        return false;
    }

    /**
     * Encontra um recurso pelo id
     * @param type $id
     * @return type
     */
    public static function find($id)
    {
        $conexao = Conexao::getInstance();
        $stmt    = $conexao->prepare("SELECT * FROM solicitante WHERE id='{$id}';");
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $admin = $stmt->fetchObject('Admin');
                if ($admin) {
                    return $admin;
                }
            }
        }
        return false;
    }

    /**
     * Destruir um recurso
     * @param type $id
     * @return boolean
     */
    public static function destroy($id)
    {
        $conexao = Conexao::getInstance();
        if ($conexao->exec("DELETE FROM solicitante WHERE id='{$id}';")) {
            return true;
        }
        return false;
    }
}
