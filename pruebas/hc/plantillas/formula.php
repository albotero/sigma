
<?php
$tipo_anexo = 'formula';

foreach ($decoded as $key_anexo => $val_anexo) {
    if(0 === strpos($key_anexo, $tipo_anexo)) {
        $formulario = !isset($decoded['firma']);
?>
<script type="text/javascript" src="/funciones/formula.js"></script>
<div id="<?php echo $key_anexo; ?>" class="formula">
    <div class="seccion">
        <div class="titulo noseleccion">F&oacute;rmula</div>
        <div class="contenido">
            <table>
                <?php
                $numero = 0;
                foreach ($val_anexo as $key_med => $val_med) {
                    $numero++;

                    $titulo = $formulario ?
                    "<label>Medicamento / Presentaci&oacute;n:</label>
                    <input type='text' name='datos[$tipo_atencion][$key_anexo][$key_med][titulo]'"
                    . " value=\"{$val_med['titulo']}\" />" : $val_med['titulo'];

                    $cantidad = $formulario ?
                    "<label>Cantidad:</label>
                    <input type='text' name='datos[$tipo_atencion][$key_anexo][$key_med][cantidad]'"
                    . " value=\"{$val_med['cantidad']}\" />" : ($val_med['cantidad'] ? "#" : "") . $val_med['cantidad'];

                    $indicaciones = $formulario ?
                    "<label><br />Indicaciones:</label>
                    <textarea name='datos[$tipo_atencion][$key_anexo][$key_med][indicaciones]' rows='2'>"
                    . $val_med['indicaciones'] . "</textarea>" : nl2br($val_med['indicaciones']);

                    $quitar = $formulario ?
                    "<th class='medicamentoQuitar'><img src='/img/trash.png'"
                    . " onclick=\"quitarMedicamento('$key_anexo', '$key_med');\"/></th>" : "";

                    echo "<tr id='$key_med' class='medicamento'>
                    <th class='medicamentoNumero'>{$numero})</th>
                    <td class='medicamentoDesc'>
                        <div class='medicamentoTitulo'>{$titulo}</div>
                        <div class='medicamentoCantidad'>{$cantidad}</div>
                        <div class='medicamentoIndicaciones'>{$indicaciones}</div>
                    </td>
                    $quitar
                    </tr>";
                }
                ?>
            </table>
            <?php
            if ($formulario) {
                echo "<div class='boton noseleccion' onclick=\"agregarMedicamento('$tipo_atencion', '$key_anexo');\">"
                . "Agregar</div>";
            }
            else {
                echo "<div class='boton noseleccion' onclick=\"imprimirFormula('$key_anexo');\">"
                . "Imprimir</div>";
            }
            ?>
        </div>
    </div>
</div>
<?php } } ?>