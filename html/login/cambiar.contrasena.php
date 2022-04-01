<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <title>Cambiar Contrase&ntilde;a</title>
        <link rel="stylesheet" href="/css/general.css">
        <link rel="stylesheet" href="/css/login.css">
    </head>
    <body>
        <div class="caja login">
        <?php if (isset($_POST['contrasena_nueva'])):

            $usuario = $_POST['usuario'];
            $actual = $_POST['contrasena_actual'];
            $nueva = $_POST['contrasena_nueva'];

            $_SESSION['ips'] = $_POST['ips'];
            require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";
            require_once "{$_SERVER['DOCUMENT_ROOT']}/login/login.class.php";
            $login=new login();

            if ($login->verificarCredenciales($usuario, $actual)) {
                $pass = password_hash($nueva, PASSWORD_DEFAULT);
                ejecutarSql("UPDATE `usuarios`
                    SET `Contrasena`='{$pass}'
                    WHERE `Usuario`='{$usuario}'");

                // Se cambió la contraseña
                echo '<p>Se cambi&oacute; correctamente la contrase&ntilde;a.</p>'
                    . '<p>En 5 segundos ser&aacute; redirigido a la página de '
                    . 'login para ingresar con la nueva contrase&ntilde;a.</p>';
                    redirect("/login", 5000);
            } else {
                // Contraseña actual incorrecta
                header("Location: /login/cambiar.contrasena.php?error=1");
            }
        ?>
        <?php else: ?>
            <form method="post" action="">
                <p><label for="usuario">Usuario:&emsp;</label>
                <input name="usuario" type="text" required /></p>
                <p><label for="contrasena_actual">Contrase&ntilde;a actual:&emsp;</label>
                <input name="contrasena_actual" type="password" required /></p>
                <p><label for="contrasena_nueva">Contrase&ntilde;a nueva:&emsp;</label>
                <input name="contrasena_nueva" type="password" required /></p>
                <p><label for="ips">Instituci&oacute;n:&emsp;</label>
                <select name="ips">
                    <?php
                    require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";
                    if (strpos($_SERVER['SERVER_NAME'], 'pruebas') !== false) {
                        $nombre = BASEDATOS::BASES['pruebas'];
                        echo "<option value='pruebas'>$nombre</option>";
                    }
                    else {
                        foreach (BASEDATOS::BASES as $ips => $nombre) {
                            if ($ips != "pruebas")
                                echo "<option value='$ips'>$nombre</option>";
                        }
                    }
                    ?>
                </select></p>
                <input type="submit" value="Cambiar contrase&ntilde;a" class="boton" />
            </form>
            <?php
            if (isset($_GET['error'])) {
                echo '<p style="color: red;"><b>ERROR:</b> Usuario y/o clave actual incorrectas, '
                    . 'por favor int&eacute;ntelo nuevamente.</p>';
            }

        endif; ?>
        </div>
    </body>
</html>