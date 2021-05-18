<?php defined('crud_mvc') or die; ?>

<?php

class AnexoController extends Controller {
 
    
    public function salvarAnexos($anexo) {
        if($_SESSION['usuario_logado'] == '')
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
        }
    }
}
