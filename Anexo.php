<?php defined('crud_mvc') or die; ?>

<?php

class Anexo {

    private $atributos;

    public function __construct() {

    }

    public function __set($atributo, $valor) {
        $this->atributos[$atributo] = $valor;
        return $this;
    }

    public function __get($atributo) {
        return $this->atributos[$atributo];
    }

    public function __isset($atributo) {
        return isset($this->atributos[$atributo]);

    }

    public function save() {
        $colunas = $this->preparar($this->atributos);
        if (!isset($this->id)) {
            $query = "INSERT INTO anexo (" . implode(',' , array_keys($colunas)). ") VALUES (" . implode(',' , array_values($colunas)) . ");";
        }
        else {
            foreach($colunas as $key => $value) {
                if ($key !== 'id') {
                    $definir[] = "{$key}={$value}";
                }
            }
            $query = "UPDATE anexo SET " . implode(',' , $definir) . " WHERE id='{$this->id}';";
        }

        if ($conexao = Conexao::getInstance()) {
            $stmt = $conexao->prepare($query);
            if ($stmt->execute()) {
                return $stmt->rowCount();
            }
        }
        return false;
    }

    private function preparar($dados)
    {
        $anexo = array();
        foreach ($dados as $k => $v) {
            if (is_scalar($v)) {
                $anexo[$k] = $this->escapar($v);
            }
        }
        return $anexo;
    }

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

    public static function find($id) {
        $conexao = Conexao::getInstance();
        $stmt = $conexao->prepare("SELECT * FROM anexo WHERE contato_id='{$id}';");

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $anexo = $stmt->fetchObject('Anexo'); 
                if ($anexo) {
                    return $anexo;
                }
            }
        }
        
        return false;
    }
}