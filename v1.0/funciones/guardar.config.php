<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";
$config = $_POST['config'];
if (isset($config)) {
    ejecutarSql("UPDATE `usuarios`
        SET `Tema`='{$config['tema']}'
        WHERE `Usuario`='{$_SESSION['usr']}'");
    $_SESSION['tema'] = $config['tema'];
}
?>
<script type="text/javascript">
    location.replace(document.referrer);
</script>