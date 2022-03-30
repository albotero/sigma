
<?php
class dientePerio {
    public $area;
    public $diente;

    function __construct($area, $diente) {
        $this->area = $area;
        if ($area == 'Sup') {
            if ($diente < 8)
                $this->diente = 18 - $diente;
            else
                $this->diente = 21 - 8 + $diente;
        }
        else {
            if ($diente < 8)
                $this->diente = 48 - $diente;
            else
                $this->diente = 31 - 8 + $diente;
        }
    }
}

$tipo_anexo = 'periodontograma';
if(isset($decoded[$tipo_anexo])) {
    $formulario = !isset($decoded['firma']);

$lista_dientes = [ 'Sup' => [], 'Inf' => []];
?>
<link rel="stylesheet" href="/css/periodontograma.css">
<div id="<?php echo $tipo_anexo; ?>">
<?php
for ($i = 0; $i < 16; $i++){
    array_push($lista_dientes['Sup'], new dientePerio('Sup', $i));
    array_push($lista_dientes['Inf'], new dientePerio('Inf', $i));
}

function Titulos($dientes) {
    global $tipo_atencion;
    global $tipo_anexo;
    global $decoded;
    echo "<tr><th></th>";
    for ($c = 0; $c < 16; $c++) {
        echo "<th class='noseleccion' onclick=\"btnTitulo_click('titulo_{$dientes[$c]->diente}');\">"
        . "<input type='hidden' id='titulo_{$dientes[$c]->diente}'"
        . " name='datos[$tipo_atencion][$tipo_anexo][titulo_{$dientes[$c]->diente}]'"
        . " value=" . $decoded[$tipo_anexo]["titulo_" . $dientes[$c]->diente] . " />" . $dientes[$c]->diente
        . "</th>";
    }
    echo "</tr>";
}

function IVMP($dientes, $titulo, $opciones) {
    global $tipo_atencion;
    global $tipo_anexo;
    global $decoded;
    echo "<tr><th class='noseleccion'>" . str_replace('_', '', $titulo) . "</th>";
    for ($c = 0; $c < 16; $c++) {
        echo "<td tag='{$dientes[$c]->diente}'><input type='text' readonly onclick=\"btnIVMP_click(this, '$opciones');\""
        . " id='{$titulo}_{$dientes[$c]->diente}'"
        . " name='datos[$tipo_atencion][$tipo_anexo][{$titulo}_{$dientes[$c]->diente}]'"
        . " value='" . $decoded[$tipo_anexo][$titulo . "_" . $dientes[$c]->diente] . "'"
        . " /></td>";
    }
    echo "</tr>";
}

function LNSM($dientes, $titulo, $atributos = '') {
    global $tipo_atencion;
    global $tipo_anexo;
    global $decoded;
    echo "<tr><th class='noseleccion'>" . str_replace('_', '', $titulo) . "</th>";
    for ($c = 0; $c < 16; $c++) {
        echo "<td tag='{$dientes[$c]->diente}'><input type='text' $atributos id='{$titulo}_{$dientes[$c]->diente}'"
        . " name='datos[$tipo_atencion][$tipo_anexo][{$titulo}_{$dientes[$c]->diente}]'"
        . " oninput='pintar_all();'"
        . " value='" . $decoded[$tipo_anexo][$titulo . "_" . $dientes[$c]->diente] . "'"
        . " /></td>";
    }
    echo "</tr>";
}

function Furca($dientes) {
    global $tipo_atencion;
    global $tipo_anexo;
    global $decoded;
    echo "<tr><th>furca</th>";
    for ($c = 0; $c < 16; $c++) {
        echo "<td tag='{$dientes[$c]->diente}'>";
        $filas = '';
        switch ($dientes[$c]->diente) {
            case 18: case 17: case 16: case 26: case 27: case 28:
                // Molares superiores
                $filas = "[['Vestibular', 'V'], ['Mesopalatino', 'MP'], ['Distopalatino', 'DP']]";
            break;
            case 14: case 24:
                // Primer premolar superior
                $filas = "[['Mesial', 'M'], ['Distal', 'D']]";
            break;
            case 48: case 47: case 46: case 36: case 37: case 38:
                // Molares inferiores
                $filas = "[['Lingual', 'L'], ['Vestibular', 'V']]";
            break;
        }
        if ($filas) {
            echo "<textarea readonly id='furca_{$dientes[$c]->diente}'"
            . " onclick=\"btnFurca_click($filas, this.id);\""
            . " name='datos[$tipo_atencion][$tipo_anexo][furca_{$dientes[$c]->diente}]'"
            . " >" . $decoded[$tipo_anexo]["furca_" . $dientes[$c]->diente] . "</textarea>";
        }
        else {
            echo "<textarea readonly id='furca_{$dientes[$c]->diente}'"
            . " name='datos[$tipo_atencion][$tipo_anexo][furca_{$dientes[$c]->diente}]'"
            . " >-</textarea>";
        }
        echo "</td>";
    }
    echo "</tr>";
}

function SS($dientes, $titulo, $color) {
    global $tipo_atencion;
    global $tipo_anexo;
    global $decoded;
    echo "<tr><th class='noseleccion'>" . str_replace('_', '', $titulo) . "</th>";
    for ($c = 0; $c < 16; $c++) {
        echo "<td tag='{$dientes[$c]->diente}'><div class='ss'>";
        for ($d = 0; $d < 3; $d++) {
            $id = substr($titulo, 0, 3) . (strpos($titulo, "_") > 0 ? "_" : "")
            . "_" . $d . "_" . $dientes[$c]->diente;
            echo "<div class='$color customcb'><input type='checkbox' id='cb_$id'"
            . " name='datos[$tipo_atencion][$tipo_anexo][$id]'"
            . ($decoded[$tipo_anexo][$id] ? " checked" : "")
            . " /><label class='inner' for='cb_$id'></label></div>";
        }
        echo "</div></td>";
    }
    echo "</tr>";
}

function Img($dientes, $titulo) {
    $anchoImg = [
        'Sup' => [7.03, 7.16, 7.29, 5.50, 6.01, 5.24, 5.37, 6.39, 6.39, 5.37, 5.24, 6.01, 5.50, 7.29, 7.16, 7.03],
        'Inf' => [8.46, 7.81, 8.33, 5.85, 5.34, 4.82, 4.82, 4.56, 4.56, 4.82, 4.82, 5.34, 5.85, 8.33, 7.81, 8.46]
    ];
    $margenImg = [
        'vestibular' => [.2, .7, .45, -.2, -.3, .45, -.65, -.55, -.65, -.65, .5, -.08, -.2, .45, .55, .4],
        'palatino_' => [1, 1.5, 1.65, .35, -.2, .55, .85, -.5, -.5, .85, .55, -.2, .35, 1.35, 1.5, 1],
        'lingual' => [1, 1, .6, -.2, 0, -.35, -.25, 0, 0, -.15, -.25, .05, -.05, .6, .8, 1],
        'vestibular_' => [1, 1, 1.3, .5, -.4, 0, .4, .35, .25, .25, 0, -.4, .5, 1.3, 1, 1]
    ];
    $tipoMargenImg = [
        'Sup' => 'margin-bottom',
        'Inf' => 'margin-top'
    ];
    echo "<th class='noseleccion'>" . str_replace('_', '', $titulo) . "</th>"
    . "<td colspan='16'><div class='pnlimg {$dientes[0]->area}' id='pnlimg_$titulo'>";
    $panel = strpos($titulo, "_") ? "b" : "" ;
    for ($i = 0; $i < 16; $i++) {
        echo "<img id='img_{$titulo}_{$dientes[$i]->diente}' class='pic_diente'"
        . " width='{$anchoImg[$dientes[$i]->area][$i]}%'"
        . " style='{$tipoMargenImg[$dientes[$i]->area]}: {$margenImg[$titulo][$i]}%'"
        . " src='/img/perio/dientes/{$dientes[$i]->area}/{$dientes[$i]->diente}{$panel}.png' />";
    }
    echo "</div></td></tr>";
}

foreach ($lista_dientes as $area => $dientes) {
    $firma = $formulario ? '' : 'firma';
    echo "<div class='seccion'>
        <div class='titulo noseleccion'>Periodontograma - {$area}erior</div>
        <div class='contenido'>
        <table id='tblPerio$area' class='{$firma}'>";

        // Titulos de Dientes
        Titulos($dientes);
        // Implante
        IVMP($dientes, 'implante', 'No,Si');
        // Vitalidad
        IVMP($dientes, 'vitalidad', '-,+');
        // Furca
        Furca($dientes);
        // Movilidad
        IVMP($dientes, 'movilidad', '-,1,2,3');
        // Placa
        IVMP($dientes, 'placa', '0,1');
        // Supuración
        SS($dientes, 'supuraci&oacute;n', 'amarillo');
        // Sangrado
        SS($dientes, 'sangrado', 'rojo');
        // L.M.G.
        LNSM($dientes, 'lmg', ' pattern=\'-?\\d{1,2}\'');
        // N.I.
        LNSM($dientes, 'ni', ' readonly');
        // Sondaje
        LNSM($dientes, 'sondaje', ' pattern=\'-?\\d{1,2} -?\\d{1,2} -?\\d{1,2}\'');
        // Margen
        LNSM($dientes, 'margen', ' pattern=\'-?\\d{1,2} -?\\d{1,2} -?\\d{1,2}\'');
        // Imagenes
        if ($area == 'Sup') {
            Img($dientes, 'vestibular');
            Img($dientes, 'palatino_');
        }
        else {
            Img($dientes, 'lingual');
            Img($dientes, 'vestibular_');
        }
        // Margen
        LNSM($dientes, 'margen_', ' pattern=\'-?\\d{1,2} -?\\d{1,2} -?\\d{1,2}\'');
        // Sondaje
        LNSM($dientes, 'sondaje_', ' pattern=\'-?\\d{1,2} -?\\d{1,2} -?\\d{1,2}\'');
        // N.I.
        LNSM($dientes, 'ni_', ' readonly');
        // L.M.G.
        if ($area == 'Inf') {
            LNSM($dientes, 'lmg_', ' pattern=\'-?\\d{1,2}\'');
        }
        // Supuración
        SS($dientes, 'supuraci&oacute;n_', 'amarillo');
        // Sangrado
        SS($dientes, 'sangrado_', 'rojo');
        // Placa
        IVMP($dientes, 'placa_', '0,1');

        echo "</table>
        </div>
        </div>";
}
?>
</div>
<!--<script type="text/javascript" src="/funciones/tamano_diente.js"></script>-->
<script type="text/javascript" src="/funciones/periodontograma.draw_img.js"></script>
<script type="text/javascript" src="/funciones/periodontograma.eventos_controles.js"></script>
<?php } ?>