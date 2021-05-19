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

        $path = "anexos/";
        $arquivo = $path . basename($_FILES["anexo"]["name"]);

        $anexo = new Anexo;

        $anexo->caminho = $arquivo;
        $anexo->uploaded_on = date('Ymd');
        $anexo->contato_id = $this->request->contato_id;

        if (file_exists($arquivo)) {
            return $this->view('erro', ['msg' => 'Desculpe, mas o arquivo já existe!']);
        }

        if (move_uploaded_file($_FILES["anexo"]["tmp_name"], $arquivo)) {
            echo "O arquivo " . htmlspecialchars(basename($_FILES["anexo"]["name"])) . " foi salvado!";
            $anexo->save();
        } else {
            echo "Desculpe, não foi possível salvar o arquivo!";
        }
    }



    
    public function salvarAnexos($anexo) {
        /*if($_SESSION['usuario_logado'] == '')
            return $this->view('erro', ['msg' => 'Erro, a origem do envio do dado não confere!']);
                
            if(in_array($this->files->anexo['type'][0], ['application/pdf'])) {
                $arq_tmp = '';

            foreach ($this->file->anexo['tmp_name'] as $k => $v) {
                $pasta = "anexo/" . date('Ymd') . '__';
                $arq_tmp = $this->files->anexo['name'][$k];
                $anexo->caminho = $pasta.$this->files->anexo['name'][$k];

                $salvar = true;

                if (file_exists($anexo->caminho)) {
                    if (@rename($anexo->caminho, "anexo/" . basename($anexo->caminho, '.pdf')));
                }
            }
        }*/
    }
}
