<?php defined('crud_mvc') or die; ?>

<?php

class Contato {

    private $atributos;

    public function __construct() {}

    public function __set(string $atributo, $valor) {
        $this->atributos[$atributo] = $valor;
        return $this;
    }

    public function __get(string $atributo) {
        return $this->atributos[$atributo];
    }

    public function __isset($atributo) {
        return isset($this->atributos[$atributo]);
    }

    public function save() {
        
        $colunas = $this->preparar($this->atributos);

        if (!isset($this->id)) {
            $query = "INSERT INTO contatos(" . implode(',', array_keys($colunas)). ") VALUES (" . implode(',', array_values($colunas)). ");";
        } 
        else {
            foreach ($colunas as $key => $value) {
                if ($key !== 'id') {
                    $definir[] = "{$key}={$value}";
                }
            }
            $query = "UPDATE contatos SET " . implode(',' , $definir) . " WHERE id='{$this->id}';";
        } 
        if ($conexao = Conexao::getInstance()) {
            $stmt = $conexao->prepare($query);
            if ($stmt->execute()) {
                return $stmt->rowCount();
            }
        }
        return false;
    }


    /** TRANSFORMA EM DADOS ACEITOS PELO SQL */
    public function escapar($dados) {
        
        if (is_string($dados) & !empty($dados)) {
            return "'".addslashes($dados)."'";
        }
        else if (is_bool($dados)) {
            return $dados ? 'TRUE' : 'FALSE';
        }
        else if ($dados !== '') {
            return $dados;
        } 
        else {
            return 'NULL';
        }
    }

    /**VERIFICA SE OS DADOS SÃO ESCALARES PARA SEREM SALVOS */
    public function preparar($dados) {

        $resultado = array();
        foreach ($dados as $key => $value) {
            if(is_scalar($value)) {
                $resultado[$key] = $this->escapar($value);
            } 
        }
        return $resultado;
    }

    /**RETORNA TODOS OS OBJETOS DA CLASSE CONTATOS*/
    public static function all() {

        $conexao = Conexao::getInstance();
        $stmt = $conexao->prepare("SELECT * FROM contatos");
        $result = array();

        if ($stmt->execute()){
            while($rs = $stmt->fetchObject(Contato::class)) {
                $result[] = $rs;
            } 
        }
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }



    /**RETORNA O NÚMERO DE REGISTROS DA TABLE */
    public static function count() {

        $conexao = Conexao::getInstance();
        $count = $conexao->exec("SELECT count(*) FROM contatos;");
        if ($count) {
            return (int) count;
        } 
        return false;
    }

    public static function find($id) {

        $conexao = Conexao::getInstance();
        $stmt = $conexao->prepare("SELECT * FROM contatos WHERE id='{$id}';");
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $resultado = $stmt->fetchObject('Contato');
                if ($resultado) {
                    return $resultado;
                }
            }
        }
        return false;
    }

    public static function destroy($id) {

        $conexao = Conexao::getInstance();
        if ($conexao->exec("DELETE FROM contatos WHERE id='{$id}';")) {
            return true;
        }
        return false;
    }

}