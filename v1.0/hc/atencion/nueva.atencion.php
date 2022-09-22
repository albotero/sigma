<?php
session_start();

if (!isset($_POST['id']))
    header("Location: /hc");

require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/constantes.php";

$consecutivo = ejecutarSql("SELECT MAX(`Consecutivo`) AS `Consecutivo` FROM `historias`");
$consecutivo = ($consecutivo->fetch_assoc())['Consecutivo'];
$consecutivo++;

$creacion = date('Y-m-d H:i:s');

ejecutarSql("INSERT INTO `historias`
    (`Consecutivo`, `Carpeta`, `Creacion`, `UsuarioCreacion`, `Firma`, `UsuarioFirma`, `PacienteTipoId`, `PacienteId`)
    VALUES ('$consecutivo', '{$_POST['carpeta']}', '$creacion', '{$_SESSION['usr']}', NULL, '', '{$_POST['tipoid']}', '{$_POST['id']}')");

echo "<script type='text/javascript' src='/funciones/post.js'></script>
        <body>
            <script type='text/javascript'>
                postPage('{$_POST['tipoid']}', '{$_POST['id']}', '{$_POST['nombre']}', '$consecutivo');
            </script>
        </body>";
?>