<?php defined('crud_mvc') or die; 

if(isset($_SESSION['usuario_logado']) && strlen($_SESSION['usuario_logado']) > 0 && ($usuario) == $_SESSION['usuario_logado']) {


} else {
    (new AdminController())->formularioLogin();
    exit;
}
?>
<div class="d-flex">
<h1 class="flex-grow-1 p-2 ml-5 mt-2">CONTATOS</h1>
<a class="p-4" href="?controller=AdminController&method=sair">
    <button class="btn btn-danger">Sair</button>
</a>

</div>
<hr>
<div class="container">

    <?php if (isset($msg) && strlen($msg) > 0) { ?>
        <div id="mensagem_box" class="alert alert-<?php echo isset($msg_type) ? $msg_type : '' ?> mx-auto" role="alert">
            <h1> <?php if (isset($msg)) {  echo $msg; } else {}?></h1>
        </div>
    <?php } ?>
    <table class="table table-secondary table-bordered table-striped" style="top: 40px">
        <thead>
            <th>NOME</th>
            <th>TELEFONE</th>
            <th>E-MAIL</th>
            <th>ANEXO</th>
            <th colspan="3"><a href="?controller=ContatosController&method=criar" class="btn btn-success btn-sm">Novo</a></th>
        </thead>
        <tbody class="bg-light text-dark">
            <?php
                if ($contatos) {
                    foreach ($contatos as $contato) {
                        $anexo = Anexo::find($contato->id);
                ?>
                    <tr>
                        <td><?=$contato->nome ?></td>
                        <td><?=$contato->telefone ?></td>
                        <td><?=$contato->email ?></td>
                        <?php if (isset($anexo->caminho) && strlen($anexo->caminho) > 0) { ?>
                        <td><a href="<?php echo $anexo->caminho ?>" download="<?=$anexo->caminho?>"><?=$anexo->caminho?></a> <a onclick="return confirm('Deseja realmente excluir o anexo?')" href="?controller=AnexoController&method=excluir&id=<?=$anexo->id?>" type="button" class="btn btn-danger btn-sm float-right  text-light">X</a> </td>
                        <?php } else { ?>
                        <td>Não possui anexo</td>
                        <?php } ?>

                        <td><a href="?controller=ContatosController&method=editar&id=<?=$contato->id?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="?controller=AnexoController&method=anexar&id=<?=$contato->id?>" class="btn btn-warning btn-sm">Anexar</a>
                            <a onclick="return confirm('Deseja realmente excluir?')" href="?controller=ContatosController&method=excluir&id=<?=$contato->id?>" class="btn btn-danger btn-sm">Excluir</a>
                        </td>
                    </tr>
                <?php } 
                } else { ?>
                   
               <?php } ?>
        </tbody>
    </table>
</div>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>