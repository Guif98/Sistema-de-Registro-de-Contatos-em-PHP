<?php

class Conexao {

    private static $conexao;

    private function __construct() {

    }

    public static function getInstance() {
        if(is_null(self::$conexao)) {
            self::$conexao = new \PDO('mysql:host=localhost;port=3306;dbname=crudmvc','sorriso', 'maroto');
            self::$conexao->setAttribite(\PDO::ATR_ERRMODE, \PD0::ERRMODE_EXCEPTION);
            self::$conexao->exec('set names utf-8');      
        }
        return self::$conexao;
    }
}