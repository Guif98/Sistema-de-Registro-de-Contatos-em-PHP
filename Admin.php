<?php 

class Admin {

    private $senha, $usuario;

    public static function all() {
        $conexao = Conexao::getInstance();
        $stmt = $conexao->prepare("SELECT * FROM usuarios_permitidos");
        $resultado = array();

        if ($stmt->execute()) {
            while ($rs = $stmt->fetchObject(Admin::class)) {
                $resultado[] = $rs;
            }
        }
        if (count($resultado) > 0) {
            return $resultado;
        }
        return false;
    }

    public static function validar($usuario, $senha) {
        $usuariosPermitidos = Admin::all();
        foreach ($usuariosPermitidos as $usuarioPermitido) {
            if ($usuario == $usuarioPermitido->usuario && $senha == $usuarioPermitido->senha) {
                header("location: grade.php");
            } else {
                header("location: index.php");
            }
        }
    }
}