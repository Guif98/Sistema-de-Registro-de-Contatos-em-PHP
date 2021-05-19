<?php defined('crud_mvc') or die; 


if(isset($_SESSION['usuario_logado']) && strlen($_SESSION['usuario_logado']) > 0 && ($usuario) == $_SESSION['usuario_logado']) {

} else {
    (new AdminController())->formularioLogin();
    exit;
}
?>


<div class="container m-5 mx-auto">
    <form action="?controller=AnexoController&method=salvarArquivo" method="post" enctype="multipart/form-data">
            <div class="form-group form-row">
                <label for="arquivo" class="col-sm-2 col-form-label text-right">Anexo:</label>
                <input type="file" required class="form-control col-sm-8" name="anexo" id="anexo">
                <input type="hidden" name="contato_id" id="contato_id" value="<?=$id['id']?>">
            </div>

            <button type="submit" class="btn btn-success">Anexar</button>
    </form>
</div>