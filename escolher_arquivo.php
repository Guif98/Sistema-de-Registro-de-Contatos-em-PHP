<?php defined('crud_mvc') or die; 


if(isset($_SESSION['usuario_logado']) && strlen($_SESSION['usuario_logado']) > 0 && ($usuario) == $_SESSION['usuario_logado']) {

} else {
    (new AdminController())->formularioLogin();
    exit;
}
?>


<div class="card m-5 mx-auto w-75">
    <form action="?controller=AnexoController&method=salvarArquivo" method="post" enctype="multipart/form-data">

    <div class="card-header">
        ANEXAR:
    </div>
    <div class="card-body">
        <div class="mx-auto w-75">
            <label for="arquivo" class="text-center">Anexar arquivo:</label>
            <input type="file" required class="form-control mx-auto" name="anexo" id="anexo">
            <input type="hidden" name="contato_id" id="contato_id" value="<?=$id['id']?>">
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success">Anexar</button>
        <button type="reset" class="btn btn-secondary">Limpar</button>
        <a class="btn btn-danger" href="?controller=ContatosController&method=listar">Cancelar</a>
    </div>
        </form>
    </div>

   
</div>