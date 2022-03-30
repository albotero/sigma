<?php
const CARPETAS = [
    'cfle93lrgi' => 'Atenci&oacute;n Odontol&oacute;gica',
    'sddke03kr9' => 'Reevaluaci&oacute;n Odontol&oacute;gica',
    'e83oe84o3d' => 'Evoluci&oacute;n Odontol&oacute;gica',
    'ddk895jd74' => 'Valoraci&oacute;n Preanest&eacute;sica',
    'go84kd94kt' => 'Registro de Anestesia',
    'hiw830dk48' => 'Evoluci&oacute;n Anestesiolog&iacute;a'
];
const PLANTILLAS = [
    'cfle93lrgi' => 'odontologia.atencion',
    'sddke03kr9' => 'odontologia.reevaluacion',
    'e83oe84o3d' => 'odontologia.evolucion',
    'ddk895jd74' => 'anestesia.valoracion',
    'go84kd94kt' => 'anestesia.registro',
    'hiw830dk48' => 'anestesia.evolucion'
];
const TIPOSATENCION = [
    'cfle93lrgi' => 'atencionodontologica',
    'sddke03kr9' => 'reevaluacionodontologica',
    'e83oe84o3d' => 'evolucionodontologica',
    'ddk895jd74' => 'valoracionpreanestesica',
    'go84kd94kt' => 'registroanestesia',
    'hiw830dk48' => 'evolucionanestesia'
];
const VALORESDEFECTO = [
    'cfle93lrgi' => '{"atencionodontologica":{"ap":{"cv":"Negativo","hta":"Negativo","resp":"Negativo","tb":"Negativo","endocrino":"Negativo","dm":"Negativo","ca":"Negativo","epilepsia":"Negativo","ar":"Negativo","mental":"Negativo","hemorragia":"Negativo","congenita":"Negativo","alergia":"Negativo","cirugia":"Negativo","otro":"Negativo"},"af":{"cv":"Negativo","hta":"Negativo","resp":"Negativo","endocrino":"Negativo","dm":"Negativo","ca":"Negativo","ar":"Negativo","mental":"Negativo","hemorragia":"Negativo","otro":"Negativo"},"ho":{"ageneralcom":"Ninguna","alocalcom":"Ninguna","exodonciacom":"Ninguna","hemorragiaobs":"Ninguna"},"ttoprev":{"actitudprevio":"Buena","actitudactual":"Buena"},"hig":{"higiene":"Buena"}}}',
    'sddke03kr9' => '{"reevaluacionodontologica":{"hig":{"higiene":"Buena"}}}',
    'e83oe84o3d' => '{"evolucionodontologica":{}}',
    'ddk895jd74' => '{"valoracionpreanestesica":{"ap":{"patol":"Negativo","farm":"Negativo","qx":"Negativo","anest":"Negativo","transf":"Negativo","go":"Negativo","tox":"Negativo","otro":"Negativo"},"af":{"patol":"Negativo","anest":"Negativo","otro":"Negativo"}}}',
    'go84kd94kt' => '{"registroanestesia":{}}',
    'hiw830dk48' => '{"evolucionanestesia":{}}'
];
const GRUPOS = [
    'cfle93lrgi' => 'ODONT',
    'sddke03kr9' => 'ODONT',
    'e83oe84o3d' => 'ODONT',
    'ddk895jd74' => 'ANEST',
    'go84kd94kt' => 'ANEST',
    'hiw830dk48' => 'ANEST'
];
const ANEXOS = [
    ['id' => 'examenclinico', 'nombre' => 'Examen Clínico', 'carpetas' => 'odontologia'],
    //['id' => 'odontograma', 'nombre' => 'Odontograma', 'carpetas' => 'odontologia'],
    //['id' => 'indiceplaca', 'nombre' => 'Índice de Placa', 'carpetas' => 'odontologia'],
    ['id' => 'periodontograma', 'nombre' => 'Periodontograma', 'carpetas' => 'odontologia'],
    ['id' => 'dxplan', 'nombre' => 'Diagnóstico & Plan', 'carpetas' => 'odontologia'],

    //['id' => '+consentimiento', 'nombre' => 'Consentimiento Informado', 'carpetas' => '*'],
    //['id' => '+procedimiento', 'nombre' => 'Procedimiento', 'carpetas' => '*'],
    ['id' => '+formula', 'nombre' => 'Fórmula', 'carpetas' => '*'],
    //['id' => '%+notaaclaratoria', 'nombre' => 'Nota Aclaratoria', 'carpetas' => '*']
];
$configuracionHtml =
    "<form id=\'frmConfig\' action=\'/funciones/guardar.config.php\' method=\'post\'>"
    . "    <table>"
    . "        <tr><th>Tema:</th><td>"
    . "            <select name=\'config[tema]\'>"
    . "                <option value=\'\'" . temaSeleccionado("") . ">Predeterminado</option>"
    . "                <option value=\'gris\'" . temaSeleccionado("gris") . ">Gris</option>"
    . "                <option value=\'verde\'" . temaSeleccionado("verde") . ">Verde</option>"
    . "                <option value=\'rosado\'" . temaSeleccionado("rosado") . ">Rosado</option>"
    . "            </select>"
    . "        </td></tr>"
    . "    </table>"
    . "</form>";
$configuracionJs = "document.getElementById(\'roller\').style.display = \'block\';"
    . "document.getElementById(\'frmConfig\').submit();";
$iconosMenu = [
    ['imgsrc' => 'home.png', 'texto' => 'P&aacute;gina Inicial', 'accion' => "location.href = '/';"],
    ['imgsrc' => 'separador'],
    ['imgsrc' => 'agenda.png', 'id' => 'menuAgenda', 'texto' => 'Agenda', 'accion' => "location.href = '/agenda';"],
    ['imgsrc' => 'facturacion.png', 'id' => 'menuFacturacion', 'texto' => 'Facturaci&oacute;n', 'accion' => "location.href = '/facturacion';"],
    ['imgsrc' => 'separador'],
    ['imgsrc' => 'crear-paciente.png', 'id' => 'menuPaciente', 'texto' => 'Crear Paciente', 'accion' => "location.href = '/paciente';"],
    ['imgsrc' => 'hc.png', 'id' => 'menuHc', 'texto' => 'Historia Cl&iacute;nica', 'accion' => "location.href = '/hc';"],
    ['imgsrc' => 'separador', 'grupo' => '/hc/atencion'],
    ['imgsrc' => 'alert.png', 'grupo' => '/hc/atencion', 'id' => 'menuAlerta', 'texto' => 'Alertas', 'accion' => modalAlertas()],
    ['imgsrc' => 'folder.png', 'grupo' => '/hc/atencion', 'id' => 'menuAtencion', 'texto' => 'Nueva Atenci&oacute;n', 'accion' => atencionesPorGrupo()],
    ['imgsrc' => 'medical-report.png', 'grupo' => '/hc/atencion', 'id' => 'menuAnexos', 'texto' => 'Agregar Anexo', 'accion' => ''],
    ['imgsrc' => 'print.png', 'grupo' => '/hc/atencion', 'id' => 'menuImprimir', 'texto' => 'Imprimir HC', 'accion' => 'imprimirAtencion();'],
    ['imgsrc' => 'separador'],
    ['imgsrc' => 'settings.png', 'texto' => 'Configuraci&oacute;n', 'accion' => "mostrarModal('$configuracionHtml', '$configuracionJs', 'Configuraci&oacute;n', 'Guardar', 'Salir');"],
    ['imgsrc' => 'log-out.png', 'texto' => 'Cerrar Sesi&oacute;n', 'accion' => "location.href = '/logout';"]
];

function temaSeleccionado($tema) {
    return $tema === $_SESSION['tema'] ? " selected" : "";
}

function modalAlertas() {
    global $paciente;
    $alertas = decodificar_alertas($paciente['Alertas']);
    return "mostrarModal('<textarea id=\'textareaAlertas\' placeholder=\'Escriba aqu&iacute; las alertas del paciente\'>"
    . "$alertas</textarea>', 'url_alerta(\'{$paciente['Tipo_ID']}\', \'{$paciente['ID']}\'"
    . ", \'{$paciente['Nombres']} {$paciente['Apellidos']}\')', 'Alertas', 'Guardar', 'Cancelar');";
}

function decodificar_alertas($al) {
    $al = urldecode($al);
    $al = str_replace("&#10;", "\\n", $al);
    $al = str_replace("&#039;", "\'", $al);
    return $al;
}

function atencionesPorGrupo() {
    $arr = [];
    foreach(GRUPOS as $carpeta => $grupo) {
        if (strpos($_SESSION['grupousuario'], $grupo) !== false) {
            // El usuario pertenece al grupo de este tipo de atención
            if (isset($_POST['id'])) {
                $arr[CARPETAS[$carpeta]] = "nueva_atencion('{$_POST['tipoid']}', '{$_POST['id']}', '{$_POST['nombre']}', '$carpeta');";
            }
        }
    }
    return $arr;
}
?>