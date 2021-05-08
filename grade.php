<h1>Contatos</h1>
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
                            <a href="?controller=ContatosController&method=excluir&id=<?=$contato->id?>" class="btn btn-danger btn-sm">Excluir</a>
                        </td>
                    </tr>
                <?php } 
                } else { ?>
                    <tr>
                        <td colspan="5">Nenhum registro encontrado</td>
                    </tr>
               <?php } ?>
        </tbody>
    </table>
</div>