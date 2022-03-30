<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/login/login.class.php";
$login=new login();
$login->inicia("hc");

require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";
$nombre = urldecode($_GET['nombre']); 
$alerta = (($_GET['alerta']));
ejecutarSql("UPDATE `pacientes` SET `Alertas`='$alerta' WHERE `Tipo_ID`='{$_GET['tipo']}' AND `ID`='{$_GET['id']}'");
?>
<html>
    <body>
        <script type="text/javascript" src="/funciones/post.js"></script>
        <script type="text/javascript">
            <?php echo "postPage('{$_GET['tipo']}', '{$_GET['id']}', '$nombre');"; ?>
        </script>
    </body>
</html>