<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/login/login.class.php";
$login=new login();
$login->inicia("hc");

$tipo_atencion = 'valoracionpreanestesica';
require_once "anestesia.const.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/hc/atencion/info.atencion.php";
$formulario = !isset($decoded['firma']);
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
            <?php if($formulario): ?>
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
                <?php
                function antecedentes($datos, $seccion) {
                    global $tipo_atencion;
                    $countCols = 0;
                    foreach (ANTECEDENTES[$seccion] as $clave => $valor) {
                        if ($countCols == 1) {
                            echo "</tr><tr>";
                            $countCols = 0;
                        }
                        echo "<td style='width: 30%;'>$valor:</td><td>"
                        . "<input type='text' name='datos[$tipo_atencion][$seccion][$clave]'"
                        . " value='{$datos[$seccion][$clave]}' /></td>";
                        $countCols++;
                    }
                }
                function signos($datos, $seccion, $cols) {
                    global $tipo_atencion;
                    $countCols = 0;
                    foreach (SIGNOS[$seccion] as $clave => $valor) {
                        if ($countCols == 0) {
                            echo "<tr>";
                        }
                        echo "<td style='white-space: nowrap;'>{$valor['titulo']}:</td>";
                        if ($valor['id']) {
                            echo "<td width='12.5%' id='{$valor['id']}'>??</td>";
                        }
                        else if ($valor['tipo'] == 'select') {
                            echo "<td><select name='datos[$tipo_atencion][$seccion][$clave]' style='text-align: center;'>";
                            foreach ($valor['opciones'] as $opc => $lbl) {
                                $sel = $datos[$seccion][$clave] == $opc ? "selected" : "";
                                echo "<option value='$opc' $sel>$lbl</option>";
                            }
                            echo "</select></td><td>{$valor['unidades']}</td>";
                        }
                        else if ($valor['nl']) {
                            echo "<td colspan='5'><input type='text' name='datos[$tipo_atencion][$seccion][$clave]'
                                value='{$datos[$seccion][$clave]}' style='width: 100%;' /></td>
                                <td>{$valor['unidades']}</td>";
                        }
                        else {
                            echo "<td><input type='text' name='datos[$tipo_atencion][$seccion][$clave]'
                                value='{$datos[$seccion][$clave]}' pattern='{$valor['patron']}'
                                {$valor['opciones']}' style='text-align: center;' /></td>
                                <td>{$valor['unidades']}</td>";
                        }
                        if ($countCols < $cols - 1 && !$valor['nl']) {
                            echo "<td width='5%'></td>";
                            $countCols++;
                        }
                        else {
                            echo "</tr>";
                            $countCols = 0;
                        }
                    }
                }
                ?>
                <div class="seccion">
                    <div class="titulo noseleccion">procedimiento</div>
                    <div class="contenido">
                        <table><tr><?php antecedentes($decoded, 'procedimiento'); ?></tr></table>
                    </div>
                </div>
                <div class="seccion">
                    <div class="titulo noseleccion">antecedentes personales</div>
                    <div class="contenido">
                        <table><tr><?php antecedentes($decoded, 'ap'); ?></tr></table>
                    </div>
                </div>
                <?php if(strcasecmp($paciente['Genero'], "femenino") == 0 && $edad >= 15 && $edad < 50):?>
                <div class="seccion">
                    <div class="titulo noseleccion">antecedentes ginecobst&eacute;tricos</div>
                    <div class="contenido">
                        <table>
                            <td>fecha de &uacute;ltima menstruaci&oacute;n:&emsp;
                                <input type="date" name="datos[<?php echo $tipo_atencion; ?>][go]" placeholder="dd / mm / aaaa"
                                    value="<?php echo $decoded['go']; ?>" /></td>
                        </table>
                    </div>
                </div>
                <?php endif;?>
                <div class="seccion">
                    <div class="titulo noseleccion">antecedentes familiares</div>
                    <div class="contenido">
                        <table><tr><?php antecedentes($decoded, 'af'); ?></tr></table>
                    </div>
                </div>
                <div class="seccion">
                    <div class="titulo noseleccion">revisi&oacute;n por sistemas</div>
                    <div class="contenido">
                        <textarea name="datos[<?php echo $tipo_atencion; ?>][rs]" rows="3"><?php
                            echo $decoded['rs'];
                        ?></textarea>
                    </div>
                </div>
                <div class="seccion">
                    <div class="titulo noseleccion">signos vitales</div>
                    <div class="contenido">
                        <table><?php signos($decoded, 'signosvitales', 4); ?></table>
                    </div>
                </div>
                <div class="seccion">
                    <div class="titulo noseleccion">v&iacute;a a&eacute;rea</div>
                    <div class="contenido">
                        <table>
                            <?php $colSignos = 3; signos($decoded, 'viaaerea', $colSignos); ?>
                            <tr>
                                <td>otro:</td>
                                <td colspan="<?php echo $colSignos * 3; ?>">
                                    <textarea name="datos[<?php echo $tipo_atencion; ?>][viaaerea][otro]" rows="2"><?php
                                        echo $decoded['viaaerea']['otro'];
                                    ?></textarea></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="seccion">
                    <div class="titulo noseleccion">examen f&iacute;sico</div>
                    <div class="contenido">
                        <table><?php
                            foreach(EF as $key => $tit) {
                                $detalle = '';                                
                                $valores = ['No evaluado', 'Normal', 'Alterado'];
                                $valor = "<td><div class='rdb'>";
                                foreach ($valores as $val) {
                                    $check = (!$decoded['ef'][$key] && $val == "No evaluado") ||
                                        ($decoded['ef'][$key] == $val);
                                    $valor .= "<label>"
                                    . "<input type='radio' name='datos[$tipo_atencion][ef][$key]'"
                                    . " value='$val'" . ($check ? ' checked' : '' ) . "/>"
                                    . "$val</label>";
                                }
                                $valor .= "</div></td>";
                                $detalle = "<td style='width: 100%;'><input type='text' name='datos[$tipo_atencion][ef][{$key}det]'"
                                . " value='{$decoded['ef'][$key.'det']}' /></td>";
                                echo "<tr><td>$tit:</td>$valor$detalle</tr>";
                            }
                        ?></table>
                    </div>
                </div>
                <div class="seccion">
                    <div class="titulo noseleccion">ayudas diagn&oacute;sticas</div>
                    <div class="contenido">
                        <table>
                            <tr>
                                <td>fecha:</td>
                                <td colspan="5"><input type='date' name='<?php echo "datos[$tipo_atencion][lab][fecha]"; ?>'
                                value='<?php echo $decoded['lab']['fecha']; ?>' placeholder="dd / mm / aaaa"
                                style='text-align: center;' /></td>
                            </tr>
                            <?php $colSignos = 3; signos($decoded, 'lab', $colSignos); ?>
                            <tr>
                                <td>otros:</td>
                                <td colspan="<?php echo $colSignos * 3; ?>">
                                    <textarea name="datos[<?php echo $tipo_atencion; ?>][lab][otros]" rows="2"><?php
                                        echo $decoded['lab']['otros'];
                                    ?></textarea></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="seccion">
                    <div class="titulo noseleccion">plan</div>
                    <div class="contenido">
                        <table>
                            <?php $colSignos = 3; signos($decoded, 'plan', $colSignos); ?>
                            <tr>
                                <td>anestesia:</td>
                                <td colspan="10"><div class="rdb">
                                    <?php
                                    foreach (ANESTESIA as $clave => $valor) {
                                        echo "<label>"
                                        . "<input type='hidden' name='datos[$tipo_atencion][plan][anestesia][$clave]' value='0' />"
                                        . "<input type='checkbox' name='datos[$tipo_atencion][plan][anestesia][$clave]' value='1'"
                                        . ($decoded['plan']['anestesia'][$clave] == 1 ? " checked" : "") . " />"
                                        . "$valor</label>";
                                    }
                                    ?>
                                </div></td>
                            </tr>
                            <tr>
                                <td colspan="<?php echo $colSignos * 3 + 1; ?>">
                                    observaciones:
                                    <textarea name="datos[<?php echo $tipo_atencion; ?>][plan][observaciones]" rows="3"><?php
                                        echo $decoded['plan']['observaciones'];
                                    ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php require_once "anestesia.anexos.php"; ?>
                <input type="submit" name="recargar" id="btnRecargar" style="display: none;" />
                <input type="submit" name="guardar" id="btnGuardar" style="display: none;" />
                <input type="submit" name="firmar" id="btnFirmar" style="display: none;" />
            </form>
            <div class="botones">
                <input type="submit" value="Guardar Cambios" class="boton" onclick="parent.document.getElementById('roller').style.display = 'block';document.getElementById('btnGuardar').click();" />
                <input type="submit" value="Firmar Atenci&oacute;n" class="boton" onclick="parent.firma_confirmar();" />
            </div>
            <?php
            else:
            function antecedentes($datos, $seccion) {
                $countCols = 0;
                foreach (ANTECEDENTES[$seccion] as $clave => $valor) {
                    if ($countCols == 1) {
                        echo "</tr><tr>";
                        $countCols = 0;
                    }
                    echo "<td style='font-weight: 600; width: 25%;'>$valor:</td><td>{$datos[$seccion][$clave]}</td>";
                    $countCols++;
                }
            }
            function signos($datos, $seccion, $cols) {
                $countCols = 0;
                foreach (SIGNOS[$seccion] as $clave => $valor) {
                    if ($countCols == 0) {
                        echo "<tr>";
                    }
                    $colspan = $valor['nl'] ? "colspan='5'" : "";
                    $w = 100 / ($cols);
                    echo "<td $colspan style='width: {$w}%; vertical-align: top;'><span style='font-weight: 600;'>{$valor['titulo']}:</span> ";
                    if ($valor['id']) {
                        echo "<span id='{$valor['id']}'>{$datos[$seccion][$clave]}</span> {$valor['unidades']}</td>";
                    }
                    else if ($valor['tipo'] == 'select') {
                        echo "{$valor['opciones'][$datos[$seccion][$clave]]} {$valor['unidades']}</td>";
                    }
                    else if ($clave == 'pa' || $clave == 'peso' || $clave == 'talla') {
                        echo "<span id='$clave'>{$datos[$seccion][$clave]}</span> {$valor['unidades']}</td>";
                    }
                    else if ($clave == 'pam' || $clave == 'imc') {
                        echo "<span id='{$valor['id']}'>{$datos[$seccion][$clave]}</span> {$valor['unidades']}</td>";
                    }
                    else {
                        echo "{$datos[$seccion][$clave]} {$valor['unidades']}</td>";
                    }
                    if ($countCols < $cols - 1 && !$valor['nl']) {
                        $countCols++;
                    }
                    else {
                        echo "</tr>";
                        $countCols = 0;
                    }
                }
            }
            ?>
            <div class="seccion">
                <div class="titulo noseleccion">procedimiento</div>
                <div class="contenido">
                    <table><tr><?php antecedentes($decoded, 'procedimiento'); ?></tr></table>
                </div>
            </div>
            <div class="seccion">
                <div class="titulo noseleccion">antecedentes personales</div>
                <div class="contenido">
                    <table><tr><?php antecedentes($decoded, 'ap'); ?></tr></table>
                </div>
            </div>
            <?php if(strcasecmp($paciente['Genero'], "femenino") == 0 && $edad >= 15 && $edad < 50):?>
            <div class="seccion">
                <div class="titulo noseleccion">antecedentes ginecobst&eacute;tricos</div>
                <div class="contenido">
                    <table>
                        <td><span style="font-weight: 600;">fecha de &uacute;ltima menstruaci&oacute;n:</span>&emsp;
                            <?php echo $decoded['go']; ?></td>
                    </table>
                </div>
            </div>
            <?php endif;?>
            <div class="seccion">
                <div class="titulo noseleccion">antecedentes familiares</div>
                <div class="contenido">
                    <table><tr><?php antecedentes($decoded, 'af'); ?></tr></table>
                </div>
            </div>
            <div class="seccion">
                <div class="titulo noseleccion">revisi&oacute;n por sistemas</div>
                <div class="contenido"><?php echo nl2br($decoded['rs']); ?></div>
            </div>
            <div class="seccion">
                <div class="titulo noseleccion">signos vitales</div>
                <div class="contenido">
                    <table><?php signos($decoded, 'signosvitales', 4); ?></table>
                </div>
            </div>
            <div class="seccion">
                <div class="titulo noseleccion">v&iacute;a a&eacute;rea</div>
                <div class="contenido">
                    <table>
                        <?php signos($decoded, 'viaaerea', 3); ?>
                        <tr>
                            <td colspan="10"><span style="font-weight: 600;">otro:</span> <?php
                                echo nl2br($decoded['viaaerea']['otro']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="seccion">
                <div class="titulo noseleccion">examen f&iacute;sico</div>
                <div class="contenido">
                    <table><?php
                        foreach(EF as $key => $tit) {
                            $detalle = '';
                            $valor = "<td class='rdb'>{$decoded['ef'][$key]}</td>";
                            if ($decoded['ef'][$key.'det'])
                                $detalle = "<td style='width: 100%;'>{$decoded['ef'][$key.'det']}</td>";
                            echo "<tr><td style='font-weight: 600; vertical-align: top;'>$tit:</td>$valor$detalle</tr>";
                        }
                    ?></table>
                </div>
            </div>
            <div class="seccion">
                <div class="titulo noseleccion">ayudas diagn&oacute;sticas</div>
                <div class="contenido">
                    <table>
                        <tr>
                            <td><span style="font-weight: 600;">fecha:</span> <?php
                                echo $decoded['lab']['fecha']; ?></td>
                        </tr>
                        <?php signos($decoded, 'lab', 3); ?>
                        <tr>
                            <td colspan="10"><span style="font-weight: 600;">otros:</span><?php
                                echo nl2br($decoded['lab']['otros']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="seccion">
                <div class="titulo noseleccion">plan</div>
                <div class="contenido">
                    <table>
                        <?php signos($decoded, 'plan', 3); ?>
                        <tr>
                            <td colspan="10"><span style="font-weight: 600;">anestesia:</span> <?php
                                $res = array();
                                foreach (ANESTESIA as $clave => $valor) {
                                    if ($decoded['plan']['anestesia'][$clave] == 1) {
                                        array_push($res, $valor);
                                    }
                                }
                                echo implode(", ", $res);
                            ?></td>
                        </tr>
                        <tr>
                            <td colspan="10"><span style="font-weight: 600;">observaciones:</span><br /><?php
                                echo nl2br($decoded['plan']['observaciones']);
                            ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php 
            require_once "anestesia.anexos.php";
            endif;
            ?>
            <script type="text/javascript">
                let txtPa = document.getElementById('pa');
                let txtPeso = document.getElementById('peso');
                let txtTalla = document.getElementById('talla');
                let tdPAM = document.getElementById('tdPAM');
                let tdIMC = document.getElementById('tdIMC');
                function calcular_pam() {
                    try {
                        var pa = txtPa.<?php echo $formulario ? "value" : "textContent"; ?>.split('/');
                        var pas = parseFloat(pa[0]);
                        var pad = parseFloat(pa[1]);
                        var PAM = (pas + 2 * pad) / 3;
                        if (PAM)
                            tdPAM.textContent = PAM.toFixed(0);
                        else
                            tdPAM.textContent = '??';
                    } catch {
                        tdPAM.textContent = '??';
                    }
                }
                function calcular_imc() {
                    try {
                        var peso = parseFloat(txtPeso.<?php echo $formulario ? "value" : "textContent"; ?>.replace(',', '.'));
                        var talla = parseFloat(txtTalla.<?php echo $formulario ? "value" : "textContent"; ?>.replace(',', '.'));
                        var IMC = peso / Math.pow(talla, 2);
                        if (IMC)
                            tdIMC.innerHTML = IMC.toFixed(1);
                        else
                            tdIMC.textContent = '??';
                    } catch {
                        tdIMC.textContent = '??';
                    }
                }
                calcular_pam();
                calcular_imc();
            </script>
        </div>
    </body>
</html>