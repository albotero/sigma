<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/login/login.class.php";
$login=new login();
$login->inicia("hc");

$tipo_atencion = 'evolucionodontologica';
require_once "odontologia.const.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/hc/atencion/info.atencion.php";
?>
<!DOCTYPE html>
<html class="<?php echo $_SESSION['tema']; ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/css/general.css">
        <link rel="stylesheet" href="/css/historia.css">
    </head>
    <body>
        <div class="atencion">
            <?php if(!isset($decoded['firma'])): ?>
            <form method="post" action="/hc/atencion/guardar.hc.php" autocomplete="off">
                <input type="hidden" name="d" value="<?php echo $_POST['d']; ?>" />
                <input type="hidden" name="c" value="<?php echo $_POST['c']; ?>" />
                <?php
                foreach ($paciente as $clave => $valor) {
                    echo "<input type='hidden' name='paciente[$clave]' value='$valor' />";
                }
                ?>
                <input type="hidden" name="tipo" value="<?php echo $tipo_atencion; ?>" />
                <input type="hidden" name="datos[<?php echo $tipo_atencion; ?>][creacion]"
                    value="<?php echo $fecha_creacion; ?>" />
                <input type="hidden" name="datos[<?php echo $tipo_atencion; ?>][usuario]"
                    value="<?php echo $profesional['Usuario']; ?>" />
                <div class="seccion">
                    <div class="titulo noseleccion">evoluci&oacute;n</div>
                    <div class="contenido">
                        <textarea name="datos[<?php echo $tipo_atencion; ?>][evo]" rows="4"><?php
                            echo $decoded['evo'];
                        ?></textarea>
                    </div>
                </div>
                <?php require_once "odontologia.anexos.php"; ?>
                <input type="submit" name="recargar" id="btnRecargar" style="display: none;" />
                <input type="submit" name="guardar" id="btnGuardar" style="display: none;" />
                <input type="submit" name="firmar" id="btnFirmar" style="display: none;" />
            </form>
            <div class="botones">
                <input type="submit" value="Guardar Cambios" class="boton" onclick="parent.document.getElementById('roller').style.display = 'block';document.getElementById('btnGuardar').click();" />
                <input type="submit" value="Firmar Atenci&oacute;n" class="boton" onclick="parent.firma_confirmar();" />
            </div>
            <?php else: ?>
            <div class="seccion">
                <div class="titulo noseleccion">evoluci&oacute;n</div>
                <div class="contenido"><?php echo nl2br($decoded['evo']); ?></div>
            </div>
            <?php
            require_once "odontologia.anexos.php";
            endif;
            ?>
        </div>
    </body>
</html>