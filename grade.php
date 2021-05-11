<?php defined('crud_mvc') or die; 

if(isset($_SESSION['usuario_logado']) && strlen($_SESSION['usuario_logado']) > 0 && ($usuario) == $_SESSION['usuario_logado']) {


} else {
    (new AdminController())->formularioLogin();
    exit;
}
?>
<div class="d-flex">
<h1 class="flex-grow-1 p-2">Contatos</h1>
<a class="p-4" href="?controller=AdminController&method=sair">
    <button class="btn btn-danger">Sair</button>
</a>

</div>
<hr>
<div class="container">
    <table class="table table-bordered table-striped" style="top: 40px">
        <thead>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Email</th>
            <th><a href="?controller=ContatosController&method=criar" class="btn btn-success btn-sm">Novo</a></th>
        </thead>
        <tbody>
            <?php
                if ($contatos) {
                    foreach ($contatos as $contato) { 
                ?>
                    <tr>
                        <td><?=$contato->nome ?></td>
                        <td><?=$contato->telefone ?></td>
                        <td><?=$contato->email ?></td>
                        <td><a href="?controller=ContatosController&method=editar&id=<?=$contato->id?>" class="btn btn-primary btn-sm">Editar</a>
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