<?php defined('crud_mvc') or die; 
    unset($_SESSION['usuario_logado']);
?>

<div class="alert alert-dark" role="alert">
<h4 class="text-center">Login do sistema de cadastros:</h4>
<form action="?controller=AdminController&method=logar" method="post" >

        <div class="form-group">
            <label class="col-form-label text-right">USUÁRIO:</label>
            <input type="text" maxlength="11" minlength="11" class="form-control col-sm" name="usuario" id="usuario" pattern="[0-9]+$" required="required" onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
        </div>

        <div class="form-group">
            <label class="col-form-label text-right">SENHA:</label>
            <input type="password" maxlength="11" minlength="11" class="form-control col-sm" name="senha" id="senha" pattern="[0-9]+$" required="required" onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
        </div>

        <div>
            <input type="hidden" name="t_k_u" id="t_k_u" value="<?php $t_k_u = md5(rand()); $_SESSION['t_k_u_form_hidden'] = $t_k_u; echo $t_k_u; ?>" />
            <button class="btn btn-success" type="submit">Logar</button>
            <button class="btn btn-secondary" onclick="history.go(0)" type="reset">Limpar campos</button>
        </div>

</form>
</div>