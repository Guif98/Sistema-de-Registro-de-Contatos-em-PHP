<?php defined('crud_mvc') or die; ?>


<?php

class ContatosController extends Controller {

    /** Envia todos os contatos para a view */
    public function listar() {
        if(!isset($_SESSION) || $_SESSION['usuario_logado'] == '')
        return $this->view('erro', ['msg' => 'Erro, a origem do envio do dado não confere!']);     

        $contatos = Contato::all();
        $usuario = base64_decode($_SESSION['usuario_logado']);
        return $this->view('grade', ['contatos' => $contatos, 'usuario' => base64_encode($usuario)]);
    }

    public function criar() {
        if(!isset($_SESSION) || $_SESSION['usuario_logado'] == '')
            return $this->view('erro', ['msg' => 'Erro, a origem do envio do dado não confere!']);     


        $usuario = base64_decode($_SESSION['usuario_logado']);
        return $this->view('form', ['usuario' => base64_encode($usuario)]);
    }

    public function editar($dados) {
        if(!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] == '') {
            return $this->view('erro', ['msg' => 'Erro, a origem do envio do dado não confere!']);     
        }
        $id = (int) $dados['id'];
        $contato = Contato::find($id);

        $usuario = base64_decode($_SESSION['usuario_logado']);
        return $this->view('form', ['contato' => $contato, 'usuario' => base64_encode($usuario)]);
    }

    public function salvar() {
        if (isset($_POST['randcheck']) && $_SESSION['rand'] == $_POST['randcheck']) {
            if($_SESSION['usuario_logado'] == '')
                return $this->view('erro', ['msg' => 'Erro, a origem do envio do dado não confere!']);     

                
                $contato = new Contato;
                $contato->nome = $this->request->nome;
                $contato->telefone = $this->request->telefone;
                $contato->email = $this->request->email;
                if ($contato->save()) {
                return $this->listar();
            }
        } else {
            return $this->listar();
        }
        
    }

    public function atualizar($dados) {
        if($_SESSION['usuario_logado'] == '')
        return $this->view('erro', ['msg' => 'Erro, a origem do envio do dado não confere!']);     


        $id = (int) $dados['id'];
        $contato = Contato::find($id);
        $contato->nome = $this->request->nome;
        $contato->telefone = $this->request->telefone;
        $contato->email = $this->request->email;
        $contato->save();
        return $this->listar();
    }

    public function excluir($dados) {
        if(!isset($_SESSION) || $_SESSION['usuario_logado'] == '')
        return $this->view('erro', ['msg' => 'Erro, a origem do envio do dado não confere!']);     

        $id = (int) $dados['id'];
        $contato = Contato::destroy($id);
        return $this->listar();
    }
}