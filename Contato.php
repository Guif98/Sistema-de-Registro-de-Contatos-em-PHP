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
                    $definir[] = "{key}={value}";
                }
            }
            $query = "UPDATE contatos SET" . implode(',' , $definir);
        } 
        if ($conexao = Conexao::getInstance()) {
            $stmt = $conexao->prepare($query);
            if ($stmt->execute()) {
                return $stmt->rowCount();
            }
        }
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


}