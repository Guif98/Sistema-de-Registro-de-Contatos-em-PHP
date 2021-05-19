<?php defined('crud_mvc') or die; ?>

<?php

class AnexoController extends Controller {


    public function anexar($id) {
        if(!isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] == '')
            return $this->view('erro', ['msg' => 'Erro, a origem do envio do dado não confere!']);

        $usuario = base64_decode($_SESSION['usuario_logado']);

        return $this->view('escolher_arquivo', ['usuario' => base64_encode($usuario), 'id' => $id]);
    }


    public function salvarArquivo() {
        if($_SESSION['usuario_logado'] == '')
            return $this->view('erro', ['msg' => 'Erro, a origem do envio do dado não confere!']);

            $usuario = base64_decode($_SESSION['usuario_logado']);
            $contatos = Contato::all();

        if (isset($_FILES["anexo"])) {
            $path = "anexos/";
            $arquivo = $path . basename($_FILES["anexo"]["name"]);

            if (file_exists($arquivo)) {
                return $this->view('erro', ['msg' => 'Desculpe, mas o arquivo já existe!']);
            }

            $anexo = new Anexo;
            
            if ($anexo->find($this->request->contato_id)) {
                return $this->view('grade', ['usuario' => base64_encode($usuario), 'contatos' => $contatos, 'msg' => 'O contato já possui anexo!', 'msg_type' => 'danger']);
            }

            $anexo->caminho = $arquivo;
            $anexo->uploaded_on = date('Ymd');
            $anexo->contato_id = $this->request->contato_id;

          

            if (move_uploaded_file($_FILES["anexo"]["tmp_name"], $arquivo)) {
                if ($anexo->save()) {
                    return $this->view('grade', ['usuario' => base64_encode($usuario), 'contatos' => $contatos, 'msg' => 'Arquivo salvo com sucesso', 'msg_type' => 'success']);
                }
            } else {
                return $this->view('erro', ['msg' => 'Desculpe, não foi possível salvar o arquivo!']) ;
            }
        }
        return $this->view('grade', ['usuario' => base64_encode($usuario), 'contatos' => $contatos]);
    }

    public function excluir($dados) {
        if(!isset($_SESSION) || $_SESSION['usuario_logado'] == '')
        return $this->view('erro', ['msg' => 'Erro, a origem do envio do dado não confere!']);     

        $usuario = base64_decode($_SESSION['usuario_logado']);
        $contatos = Contato::all();


        $id = (int) $dados['id'];

        $anexoUnlink = Anexo::findUnlink($id);

        unlink($anexoUnlink->caminho);


        $anexo = Anexo::destroy($id);
        return $this->view('grade', ['usuario' => base64_encode($usuario), 'contatos' => $contatos]);
    }
}
