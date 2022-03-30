
<?php
$tipo_anexo = 'dxplan';
if(isset($decoded[$tipo_anexo])) {
    $formulario = !isset($decoded['firma']);
?>
<div id="<?php echo $tipo_anexo; ?>">
    <div class="seccion">
        <div class="titulo noseleccion">Diagn&oacute;stico(s)</div>
        <div class="contenido">
            <?php echo $formulario ?
                "<textarea name='datos[$tipo_atencion][$tipo_anexo][dx]' rows='2'>"
                . $decoded[$tipo_anexo]['dx'] . "</textarea>" :
                nl2br($decoded[$tipo_anexo]['dx']);
            ?>
        </div>
    </div>
    <div class="seccion">
        <div class="titulo noseleccion">Plan</div>
        <div class="contenido">
            <?php echo $formulario ?
                "<textarea name='datos[$tipo_atencion][$tipo_anexo][plan]' rows='4'>"
                . $decoded[$tipo_anexo]['plan'] . "</textarea>" :
                nl2br($decoded[$tipo_anexo]['plan']);
            ?>
        </div>
    </div>
</div>
<?php } ?>