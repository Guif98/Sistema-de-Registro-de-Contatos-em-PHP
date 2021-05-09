<?php defined('crud_mvc') or die; 

echo '<nav class="navbar navbar-light bg-light justify-content-between">';
echo '<div class="col"><a href=".">Resultado COVID-19</a></div><div class="col">';

if(isset($_SESSION['usuario_logado']) && strlen($_SESSION['usuario_logado']) > 0) {
   
    echo '<a href="?c=AdminController&method=sair" class="menus navbar-brand navbar-right"><span class="btn btn-info"><span class="glyphicon glyphicon-remove"></span> &nbsp;Sair</span></a>';
    
    echo '<a class="menus navbar-brand navbar-right" href="?c=AdminController&method=escolherArquivo&colaborador=' . $_SESSION['usuario_logado'] . '"></span><span class="btn btn-info"><span class="glyphicon glyphicon-upload"></span> &nbsp;Arquivos</span></a>';
    
    echo '<a href="?c=AdminController&method=inserirSolicitacao&colaborador=' . $_SESSION['usuario_logado'] . '" class="menus navbar-brand navbar-right"><span class="btn btn-info"><span class="glyphicon glyphicon-list-alt"></span> &nbsp;Solicitacao</span></a>';

    echo '<a href="?c=AdminController&method=admin&colaborador=' . $_SESSION['usuario_logado'] . '#aba-1" class="menus navbar-brand navbar-right"><span class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> &nbsp;Gerenciar</span></a>';

    

} else {
    
    echo '<a href="?c=AdminController&method=acesso" class="menus navbar-brand navbar-right"><span class="btn btn-info"><span class="glyphicon glyphicon-user"></span> &nbsp;Acesso</span></a>';

}
echo '</div></nav><hr>';
