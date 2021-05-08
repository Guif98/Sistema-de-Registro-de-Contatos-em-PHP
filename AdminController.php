<?php defined('crud_mvc') or die; ?>
<?php

class AdminController extends Controller
{


    public function admin () {
        $cpf_colaborador = ($this->request->colaborador);
        return $this->view('tela_admin', ['cpf_colaborador' => $cpf_colaborador]);
    }

    public function sair() {
        unset($_SESSION['usuario_logado']);
        unset($_SESSION['last_request_get']);
        unset($_SESSION['last_request_post']);
 
        return $this->acesso();
    }

    public function formularioLogin() {
        return $this->view('login'); 
    }

    public function escolherArquivo($dados) {

        // controlar session 
        $cpf = base64_decode($this->request->colaborador);// receber o cpf_colaborador
        return $this->view('escolher_arquivo', ['cpf_colaborador' => base64_encode($cpf)]);
        
    }

    public function loginAD($usuario, $senha) {

        if(strlen($usuario) != 11 && !is_numeric($usuario) && strlen($senha) < 1) {
            return false;
        }
        
        $admin = new Admin();
        $usuarios = $admin->findAllUsuariosPermitidos();
        $cpfs = array();

        foreach($usuarios as $usuario) {
            if(is_null($usuario->desativado))
                $cpfs[] = $usuario->usuario;
        }

        
        if(!in_array($usuario, $cpfs)) {
            return false;
        }

        return true;
    }

    public function status() {

        $id = strip_tags($this->request->id);

        $cpf_colaborador = $this->request->cpf_colaborador;
        
        $admin = new Admin();

        $teste = md5($cpf_colaborador . $id);

        if($_SESSION['no_f5'] != $teste) {

            $_SESSION['no_f5'] = $teste;

            if($admin->status($id)) {
                $msg = 'Status de acesso alterado!';
            }
        }

        $usuarios = $admin->findAllUsuarioAcesso();

        return $this->view('tela_admin', ['msg' => $msg, 'cpf_colaborador' => $cpf_colaborador, 'usuarios' => $usuarios]);

    }
  

    public function logar()
    {
        print_r($_POST);

        if(!isset($_SESSION['t_k_u_form_hidden'])) return $this->view('erro', ['msg' => 'Erro, favor voltar a página inicial e atualizar a página!']);

        $hidden = (strlen($_SESSION['t_k_u_form_hidden']) > 0) ? $_SESSION['t_k_u_form_hidden'] : 'nokt_k_u_form_hidden';
        $t_k_u = strip_tags((strlen($this->request->t_k_u) > 0) ? $this->request->t_k_u : 'nok_t_k_u');

        if($t_k_u == $hidden) {
            
            $contatos = Contato::all();
            $cpf = ($this->request->usuario);
            $senha = ($this->request->senha);

            if($this->loginAD($usuario, $senha)) {
                $_SESSION['usuario_logado'] = base64_encode($usuario);
                return $this->view('grade', ['cpf_colaborador' => base64_encode($cpf), 'contatos' => $contatos]);
            }else {
                echo '<div class="alert alert-danger" role="alert">Usuário não encontrado</div>';
                return $this->acesso();
            }

        } else {
            unset($_SESSION['t_k_u_form_hidden']);
            return $this->view('erro', ['msg' => 'Erro, o formulário enviado não confere com a página original, retorna a página inicial, atualize a página e tente novamente!']);
        }
        
    }
    /**
     * Mostrar formulario para criar um novo contato
     */
    public function acesso()
    {
        return $this->view('acesso_form_colaborador');
    }
   
    public function inserirSolicitacao() {
        $cpf_colaborador = ($this->request->colaborador);
        return $this->view('inserir_solicitante', ['cpf_colaborador' => $cpf_colaborador]);
    }

    public function salvar()
    {
        $inserir_solicitante = new Admin();
        $inserir_solicitante->cpf_solicitante = $this->request->cpf_solicitante;
        $inserir_solicitante->cpf_colaborador = base64_decode($this->request->t_k_colaborador);

	if($this->request->t_k_colaborador != $_SESSION['usuario_logado'] || $_SESSION['usuario_logado'] == '')
		return $this->view('erro', ['msg' => 'Erro, a origem do envio do dado não confere!']);

        $teste = md5($inserir_solicitante->cpf_solicitante . $inserir_solicitante->cpf_colaborador);
        $msg = '';
        if($_SESSION['no_f5'] != $teste) {

            $_SESSION['no_f5'] = $teste;
            if ($inserir_solicitante->save()) {
                $msg = 'Solicitante <h1> ' . $inserir_solicitante->cpf_solicitante .' </h1> cadastrado com sucesso.';
            } else {
                return $this->view('erro', ['msg' => 'Erro, não foi possível salvar os dados na base!']);
            }
        }else {
            $msg .= 'Favor inserir um novo cadastro diferente do anterior';
        } 
        return $this->view('inserir_solicitante', ['msg' => $msg, 'cpf_solicitante' => $inserir_solicitante->cpf_solicitante, 'cpf_colaborador' => base64_encode($inserir_solicitante->cpf_colaborador)]);

    }
/*
    private function gerar_senha($tamanho, $maiusculas, $numeros){
        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
        $nu = "0123456789"; // $nu contem os números
        $senha = '';
        if ($maiusculas){
            $senha .= str_shuffle($ma);
        }
        if ($numeros){
            $senha .= str_shuffle($nu);
        }
        return substr(str_shuffle($senha),0,$tamanho);
    }
*/
    public function novoUsuario() {

        if($_SESSION['usuario_logado'] == '') return $this->view('erro', ['msg' => 'Erro, favor voltar a página inicial e atualizar a página!']);

        if($this->request->cpf_colaborador != $_SESSION['usuario_logado']) 
            return $this->view('erro', ['msg' => 'Erro, favor voltar a página inicial e atualizar a página!']);

        $novo_usuario = strip_tags($this->request->novo_usuario);

        $cpf_colaborador = $this->request->cpf_colaborador;
        
        $teste = md5($novo_usuario . $cpf_colaborador);
        $msg = '';
        $admin = new Admin();

        if($_SESSION['no_f5'] != $teste) {

            $_SESSION['no_f5'] = $teste;

            
            $admin->cpf_acesso = $novo_usuario;
            $admin->cpf_colaborador = base64_decode($cpf_colaborador);

            $usuario = $admin->findCPFUsuarioAcesso($admin->cpf_acesso);
            //$admin->saveUsuarioAcesso();

            if(is_array($usuario) && count($usuario) > 0){
                $msg = 'Usuário já existe!';
            }else {
                $admin->saveUsuarioAcesso();
            }

        } else {
            $msg = 'Dado repetido!';
        }

        $usuarios = $admin->findAllUsuarioAcesso();

        return $this->view('tela_admin', ['msg' => $msg, 'cpf_colaborador' => $cpf_colaborador, 'usuarios' => $usuarios]);

    }

}
