<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/login/login.class.php";
$login=new login();
$login->inicia("facturacion");
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
        <title>SIGMA - Agenda</title>
        <link rel="stylesheet" href="/css/general.css">
    </head>
    <body>
        <?php require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/plantilla.menu.php"; ?>
        <p>Aqu&iacute; va la facturaci&oacute;n</p>
    </body>
</html>