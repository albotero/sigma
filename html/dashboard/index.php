<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/login/login.class.php";
$login=new login();
$login->inicia();
?>
<!DOCTYPE html>
<html class="<?php echo $_SESSION['tema']; ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <title>SIGMA HC</title>
        <link rel="stylesheet" href="/css/general.css">
        <link rel="stylesheet" href="/css/dashboard.css">
    </head>
    <body>
        <?php require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/plantilla.menu.php"; ?>
        <div class="tablero">
            <div class="caja boton noseleccion" onClick="window.location='/agenda';"><p>Agenda</p></div>
            <div class="caja boton noseleccion" onClick="window.location='/hc';"><p>Pacientes</p></div>
            <div class="caja boton noseleccion" onClick="window.location='/facturacion';"><p>Facturaci&oacute;n</p></div>
        </div>
    </body>
</html>