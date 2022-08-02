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
        <title>Iniciar Sesi&oacute;n</title>
        <link rel="stylesheet" href="/css/general.css">
        <link rel="stylesheet" href="/css/login.css">
    </head>
    <body>
        <div class="caja login">
            <form method="post" action="/login/login.php">
                <p><label for="usuario">Usuario:&emsp;</label>
                <input name="usuario" type="text" required /></p>
                <p><label for="contrasena">Contrase&ntilde;a:&emsp;</label>
                <input name="contrasena" type="password" required /></p>
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
                <input type="submit" value="Iniciar sesi&oacute;n" class="boton" />
                <?php
                if (isset($_GET['ref']))
                    echo '<input name="ref" type="hidden" value="'.$_GET['ref'].'" />';
                else
                    echo '<input name="ref" type="hidden" value="dashboard" />';
                ?>
            </form>
            <?php
            if (isset($_GET['error'])) {
                echo '<p style="color: red;"><b>ERROR:</b> Usuario y/o clave incorrectas</p>';
            }
            ?>
            <p class="links">
                <a href="cambiar.contrasena.php">Cambiar contrase&ntilde;a</a>&emsp;&emsp;&emsp;
                <a href="#">Recordar contrase&ntilde;a</a>
            </p>
        </div>
    </body>
</html>