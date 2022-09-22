<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/login/login.class.php";
$login=new login();
$login->inicia("hc");

$tipo_atencion = 'reevaluacionodontologica';
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
                    <div class="titulo noseleccion">motivo de consulta</div>
                    <div class="contenido">
                        <textarea name="datos[<?php echo $tipo_atencion; ?>][mc]" rows="4"><?php
                            echo $decoded['mc'];
                        ?></textarea>
                    </div>
                </div>
                <div class="seccion">
                    <div class="titulo noseleccion">enfermedad actual</div>
                    <div class="contenido">
                        <textarea name="datos[<?php echo $tipo_atencion; ?>][ea]" rows="6"><?php
                            echo $decoded['ea'];
                        ?></textarea>
                    </div>
                </div>
                <div class="seccion">
                    <div class="titulo noseleccion">estado de salud oral</div>
                    <div class="contenido">
                        <table>
                            <tr>
                            <?php
                            $countCols = 0;
                            foreach (SINTOMAS as $clave => $valor) {
                                if ($countCols == 3) {
                                    echo "</tr><tr>";
                                    $countCols = 0;
                                }                            
                                echo "<td><label>"
                                . "<input type='hidden' name='datos[$tipo_atencion][od][$clave]' value='0' />"
                                . "<input type='checkbox' name='datos[$tipo_atencion][od][$clave]' value='1'"
                                . ($decoded['od'][$clave] == 1 ? " checked" : "") . " />$valor</label></td>";
                                $countCols++;
                            }
                            ?>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="seccion">
                    <div class="titulo noseleccion">higiene oral</div>
                    <div class="contenido">
                        <table>
                            <tr>
                                <td><label class="rdb">
                                    <input type="radio" name="datos[<?php echo $tipo_atencion; ?>][hig][higiene]" value="Buena"
                                        <?php if ($decoded['hig']['higiene'] == "Buena") echo " checked"; ?> />
                                    buena
                                </label></td>
                                <td><label class="rdb">
                                    <input type="radio" name="datos[<?php echo $tipo_atencion; ?>][hig][higiene]" value="Regular"
                                        <?php if ($decoded['hig']['higiene'] == "Regular") echo " checked"; ?> />
                                    regular
                                </label></td>
                                <td><label class="rdb">
                                    <input type="radio" name="datos[<?php echo $tipo_atencion; ?>][hig][higiene]" value="Mala"
                                        <?php if ($decoded['hig']['higiene'] == "Mala") echo " checked"; ?> />
                                    mala
                                </label></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                            <?php
                            $countCols = 0;
                            foreach (HIGIENE_SEL as $clave => $valor) {
                                if ($countCols == 2) {
                                    echo "</tr><tr>";
                                    $countCols = 0;
                                }
                                echo "<td>$valor:</td><td><select name='datos[$tipo_atencion][hig][$clave]'>";
                                foreach (PICKER as $pckClave => $pckValor) {
                                    echo "<option value='$pckClave'"
                                    . ($decoded['hig'][$clave] == $pckClave ? " selected" : "")
                                    . " >$pckValor</option>";
                                }
                                echo "</select></td>";
                                if ($countCols < 1) {
                                    echo "<td style='width: 20pt;'></td>";
                                }
                                $countCols++;
                            }
                            ?>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="seccion">
                    <div class="titulo noseleccion">plan de tratamiento</div>
                    <div class="contenido">
                        <textarea name="datos[<?php echo $tipo_atencion; ?>][plan]" rows="6"><?php
                            echo $decoded['plan'];
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
                <div class="titulo noseleccion">motivo de consulta</div>
                <div class="contenido"><?php echo nl2br($decoded['mc']); ?></div>
            </div>
            <div class="seccion">
                <div class="titulo noseleccion">enfermedad actual</div>
                <div class="contenido"><?php echo nl2br($decoded['ea']); ?></div>
            </div>
            <div class="seccion">
                <div class="titulo noseleccion">estado de salud oral</div>
                <div class="contenido">
                    <table>
                        <tr>
                        <?php
                        $countCols = 0;
                        foreach (SINTOMAS as $clave => $valor) {
                            if ($countCols == 3) {
                                echo "</tr><tr>";
                                $countCols = 0;
                            }
                            echo "<td style='font-weight: 600;'>$valor:</td><td>"
                            . ($decoded['od'][$clave] == 1 ? "si" : "no") . "</td>";
                            if ($countCols < 2) {
                                echo "<td style='width: 15%;'></td>";
                            }
                            $countCols++;
                        }
                        ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="seccion">
                <div class="titulo noseleccion">higiene oral</div>
                <div class="contenido">
                    <table>
                        <tr>
                            <td style="font-weight: 600;">higiene oral:</td>
                            <td><?php echo $decoded['hig']['higiene']; ?></td>
                        </tr>
                        <tr>
                        <?php
                        $countCols = 0;
                        foreach (HIGIENE_SEL as $clave => $valor) {
                            if ($countCols == 2) {
                                echo "</tr><tr>";
                                $countCols = 0;
                            }
                            echo "<td style='font-weight: 600;'>$valor:</td><td>"
                            . PICKER[$decoded['hig'][$clave]] . "</td>";
                            if ($countCols < 1) {
                                echo "<td style='width: 15%;'></td>";
                            }
                            $countCols++;
                        }
                        ?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="seccion">
                <div class="titulo noseleccion">plan de tratamiento</div>
                <div class="contenido"><?php echo nl2br($decoded['plan']); ?></div>
            </div>
            <?php
            require_once "odontologia.anexos.php";
            endif;
        ?>
        </div>
    </body>
</html>