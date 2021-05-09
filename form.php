<?php defined('crud_mvc') or die; 

if(isset($_SESSION['usuario_logado']) && strlen($_SESSION['usuario_logado']) > 0 && ($usuario) == $_SESSION['usuario_logado']) {

} else {
    (new AdminController())->formularioLogin();
    exit;
}
?>

<div class="container">
    <form action="?controller=ContatosController&<?php echo isset($contato->id) ? "method=atualizar&id={$contato->id}": "method=salvar";?>" method="post">
        <div class="card" style="top: 40px">
            <div class="card-header">
                <span class="card-title">Contatos</span>
            </div>
            <div class="card-body">

            </div>
            <div class="form-group form-row">
                <label class="col-sm-2 col-form-label text-right">Nome:</label>
                <input type="text" class="form-control col-sm-8" name="nome" id="nome" value="<?php echo isset($contato->nome) ? $contato->nome : null ?>">
            </div>
            <div class="form-group form-row">
                <label class="col-sm-2 col-form-label text-right">Telefone:</label>
                <input type="text" class="form-control col-sm-8" name="telefone" id="telefone" value="<?php echo isset($contato->telefone) ? $contato->telefone : null ?>">
            </div>
            <div class="form-group form-row">
                <label class="col-sm-2 col-form-label text-right">E-mail:</label>
                <input type="text" class="form-control col-sm-8" name="email" id="email" value="<?php echo isset($contato->email) ? $contato->email : null ?>">
            </div>
            <div class="card-footer">
                <input type="hidden" name="t_k_c" value="<?php echo ($usuario); ?>" />
                <input type="hidden" name="id" id="id" value="<?php echo isset($contato->id) ? $contato->id : null ?>">
                <button class="btn btn-success" type="submit">Salvar</button>
                <button type="reset" onclick="history.go(0)" class="btn btn-secondary">Limpar</button>
                <a class="btn btn-danger" href="?controller=ContatosController&method=listar">Cancelar</a>
            </div>
        </div>
    </form>
</div>