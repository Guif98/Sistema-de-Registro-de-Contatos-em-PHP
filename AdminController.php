<?php

class AdminController extends Controller {

    public function logar() {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        $contatos = Contato::all();

       if (Admin::validar($usuario, $senha)) {
           return $this->view('grade', ['contatos' => $contatos]);
       }

    }
}