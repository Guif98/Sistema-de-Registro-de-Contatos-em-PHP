<?php

class AdminController extends Controller {

    public function logar() {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        Admin::validar($usuario, $senha);
    }
}