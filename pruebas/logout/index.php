<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/login/login.class.php";
$login=new login();
$login->inicia();

session_unset();
setcookie('idusuario',$idusuario,time()-60);
session_destroy();
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
        <title>Cerrar Sesi&oacute;n</title>
        <link rel="stylesheet" href="/css/general.css">
        <link rel="stylesheet" href="/css/login.css">
    </head>
    <body>
        <div class="caja login">
        <?php
        include "{$_SERVER['DOCUMENT_ROOT']}/funciones/javascript.php";
        if (isset($_SESSION['idusuario'])) {
            echo "<p>Ocurri&oacute; un error al cerrar la sesi&oacute;n.</p>";
            echo "<p><span class='regresar' onClick='history.go(-1);'>Volver</span></p>";
        }
        elseif ($_GET['r'] == "exp") {
            echo "<h1>La sesi&oacute;n ha expirado.</h1>";
            echo "<p>Para volver a iniciar sesi&oacute;n, haga ";
            echo "<span class='regresar' onClick=\"location.href='/';\">CLIC AQU&Iacute;</span>.</p>";
        }
        else {
            echo "<p>Se cerr&oacute; la sesi&oacute;n exitosamente.</p>";
            echo "<p>Ser&aacute; redirigido en 3 segundos a la p&aacute;gina de inicio.</p>";
            redirect("", 3000);
        }
        ?>
        </div>
    </body>
</html>