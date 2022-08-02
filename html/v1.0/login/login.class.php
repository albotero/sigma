<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";

class login {
    // Inicia sesion
    public function inicia($paginaactual="dashboard", $tiempo=3600, $usuario=NULL, $clave=NULL) { 
        if ($usuario==NULL && $clave==NULL) {
            // Verifica sesion
            if (isset($_SESSION['idusuario'])) {
                //echo "Estas logeado";
            } else {
                // Verifica cookie
                if (isset($_COOKIE['idusuario'])) {
                    // Restaura sesion
                    $_SESSION['idusuario']=$_COOKIE['idusuario'];
                } else {
                    // Si no hay sesion regresa al login
                    $ruta = "Location: /login";
                    if ($paginaactual != "dashboard")
                        $ruta .= "?ref=$paginaactual";
                    header($ruta);
                }
            }
        } else {
            $this->verifica_usuario($tiempo, $usuario, $clave, $paginaactual);
        }
    }  
    //  Verifica login
    public function verificarCredenciales($usr, $pass) {
        $passGuardada = ejecutarSql("SELECT `Contrasena` FROM `usuarios` WHERE `Usuario`='$usr'");        
        if ($passGuardada->num_rows > 0){
            $row = $passGuardada->fetch_assoc();
            return password_verify($pass, $row['Contrasena']);
        }
        else
            return false;
    }
    private function verifica_usuario($tiempo, $usuario, $clave, $redirect) {
        if ($this->verificarCredenciales($usuario, $clave)) {
            // Si la clave es correcta
            $idusuario=$this->codificar_usuario($usuario);
            setcookie("idusuario", $idusuario, time()+$tiempo);
            $_SESSION['idusuario']=$idusuario;
            $_SESSION['usr']=$usuario;
            $usuario = ejecutarSql("SELECT * FROM `usuarios` WHERE `Usuario`='$usuario'");
            $usuario = $usuario->fetch_assoc();
            $_SESSION['grupousuario']=$usuario['Grupo'];
            $_SESSION['tema']=$usuario['Tema'];
            header("Location: /$redirect");
        } else {
            // Si la clave es incorrecta
            $ruta = "Location: /login?";
            if ($redirect != "dashboard")
                $ruta .= "ref=$redirect&";
            $ruta .= "error=1";
            header($ruta);
        }
    }
    // Codifica idusuario
    private function codificar_usuario($usuario) {
        return md5($usuario);
    }
}
?>