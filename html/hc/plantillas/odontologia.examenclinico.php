
<?php
$tipo_anexo = 'examenclinico';
if(isset($decoded[$tipo_anexo])) {
    $formulario = !isset($decoded['firma']);
?>
<div id="<?php echo $tipo_anexo; ?>">
    <div class="seccion">
        <div class="titulo noseleccion">Signos Vitales</div>
        <div class="contenido">
            <table>
                <tr>
                    <td <?php if (!$formulario) echo "style='font-weight: 600;'"; ?> >Frecuencia cardiaca:</td>
                    <td><?php echo $formulario ?
                        "<input type='text' name='datos[$tipo_atencion][$tipo_anexo][fc]'"
                        . " value='{$decoded[$tipo_anexo]['fc']}' style='text-align: center;'"
                        . " pattern='\d+' /></td><td>" :
                        $decoded[$tipo_anexo]['fc'];
                    ?> lat/min</td>
                    <td <?php if (!$formulario) echo "style='font-weight: 600;'"; ?>>Presi&oacute;n arterial:</td>
                    <td <?php echo $formulario ? "" : "id='pa'"; ?>><?php echo $formulario ?
                        "<input type='text' name='datos[$tipo_atencion][$tipo_anexo][pa]' style='text-align: center;' pattern='\d{2,3}/\d{2,3}' placeholder='PAS/PAD'"
                        . ($formulario ? "id='pa'" : "")
                        . " onchange='calcular_pam();' onkeypress='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'"
                        . " value='{$decoded[$tipo_anexo]['pa']}' /></td><td>" :
                        $decoded[$tipo_anexo]['pa'];
                    ?> mmHg</td>
                    <td style='font-weight: 600;'>PAM:</td>
                    <td id="tdPAM">??</td>
                </tr>
                <tr>
                    <td <?php if (!$formulario) echo "style='font-weight: 600;'"; ?>>Peso:</td>
                    <td <?php echo $formulario ? "" : "id='peso'"; ?>><?php echo $formulario ?
                        "<input type='text' name='datos[$tipo_atencion][$tipo_anexo][peso]' style='text-align: center;'"
                        . ($formulario ? "id='peso'" : "")
                        . " onchange='calcular_imc();' onkeypress='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'"
                        . " value='{$decoded[$tipo_anexo]['peso']}'"
                        . " pattern='\d+([\.,]\d+)?' /></td><td>" :
                        $decoded[$tipo_anexo]['peso'];
                    ?> kg</td>
                    <td <?php if (!$formulario) echo "style='font-weight: 600;'"; ?>>Talla:</td>
                    <td <?php echo $formulario ? "" : "id='talla'"; ?>><?php echo $formulario ?
                        "<input type='text' name='datos[$tipo_atencion][$tipo_anexo][talla]' style='text-align: center;'"
                        . ($formulario ? "id='talla'" : "")
                        . " onchange='calcular_imc();' onkeypress='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'"
                        . " value='{$decoded[$tipo_anexo]['talla']}'"
                        . " pattern='[0-2]([\.,]\d+)?' /></td><td>" :
                        $decoded[$tipo_anexo]['talla'];
                    ?> m</td>
                    <td <?php if (!$formulario) echo "style='font-weight: 600;'"; ?>>IMC:</td>
                    <td id="tdIMC">??</td>
                </tr>
                <tr></tr>
            </table>
        </div>
    </div>
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
                    tdPAM.textContent = PAM.toFixed(0) + ' mmHg';
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
                    tdIMC.textContent = IMC.toFixed(1);
                else
                    tdIMC.textContent = '??';
            } catch {
                tdIMC.textContent = '??';
            }
        }
        calcular_pam();
        calcular_imc();
    </script>
    <div class="seccion">
        <div class="titulo noseleccion">Examen Intraoral</div>
        <div class="contenido">
            <table>
            <?php
            $INTRAORAL = [
                'labios' => 'Labios',
                'carrillos' => 'Carrillos',
                'surcovest' => 'Surco vestibular',
                'encia' => 'Enc&iacute;a',
                'rebordealv' => 'Reborde alveolar',
                'lengua' => 'Lengua',
                'pisoboca' => 'Piso de boca',
                'frenillos' => 'Frenillos',
                'paladarduro' => 'Paladar duro',
                'paladarblando' => 'Paladar blando',
                'amigdalasorofaringe' => 'Am&iacute;gdalas / orofaringe',
                'glandulassalivales' => 'Gl&aacute;ndulas salivales'
            ];
            foreach($INTRAORAL as $key => $tit) {
                $estilo = $formulario ? "style='width: 100%;'" : "style='font-weight: 600;'";
                $valor = '';
                $detalle = '';
                if ($formulario) {
                    $valores = ['No evaluado', 'Normal', 'Alterado'];
                    $valor = "<td><div class='rdb'>";
                    foreach ($valores as $val) {
                        $check = (!$decoded[$tipo_anexo]['intraoral'][$key] && $val == "No evaluado") ||
                            ($decoded[$tipo_anexo]['intraoral'][$key] == $val);
                        $valor .= "<label>"
                        . "<input type='radio' name='datos[$tipo_atencion][$tipo_anexo][intraoral][$key]'"
                        . " value='$val'" . ($check ? ' checked' : '' ) . "/>"
                        . "$val</label>";
                    }
                    $valor .= "</div></td>";
                    $detalle = "<td>Detalle:</td>"
                    . "<td><input type='text' name='datos[$tipo_atencion][$tipo_anexo][intraoral][{$key}det]'"
                    . " value='{$decoded[$tipo_anexo]['intraoral'][$key.'det']}' /></td>";
                }
                else {
                    $valor = "<td>{$decoded[$tipo_anexo]['intraoral'][$key]}</td>";
                    if ($decoded[$tipo_anexo]['intraoral'][$key.'det'])
                        $detalle = "<td>Detalle:</td><td>{$decoded[$tipo_anexo]['intraoral'][$key.'det']}</td>";
                }
                echo "<tr><td $estilo>$tit:</td>$valor$detalle</tr>";
            }
            ?>
            </table>
        </div>
    </div>
</div>
<?php } ?>