<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/constantes.php";

if (isset($_GET['c']))
    consultarConsecutivo();

function consultarConsecutivo() {
    session_start();
    $historia = ejecutarSql("SELECT * FROM `historias` WHERE `Consecutivo`='{$_GET['c']}'");
    if ($historia->num_rows > 0){
        $row = $historia->fetch_assoc();
        $carpeta = $row['Carpeta'];

        // Carga los datos en variables y luego envía a la plantilla correspondiente
        $archivo = file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/../Atenciones/{$_SESSION['ips']}/$carpeta/{$_GET['c']}");
        $paciente = ejecutarSql("SELECT * FROM `pacientes` WHERE `Tipo_ID`='{$row['PacienteTipoId']}' AND `ID`='{$row['PacienteId']}'");
        $paciente = $paciente->fetch_assoc();
        $paciente = json_encode($paciente);

        // Si es una HC nueva, carga los valores por defecto
        if (!$archivo) {
            $archivo = VALORESDEFECTO[$carpeta];
        }
        
        echo "<form name='fr' action='/hc/plantillas/" . PLANTILLAS[$carpeta] . ".php#" . urldecode($_GET['r']) . "' method='post'>"
        . "<input type='hidden' name='paciente' value='" . base64_encode($paciente) . "' />"
        . "<input type='hidden' name='datos' value='" . base64_encode($archivo) . "' />"
        . "<input type='hidden' name='d' value='{$_GET['d']}' />"
        . "<input type='hidden' name='c' value='{$_GET['c']}' />"
        . "</form>"
        . "<script type='text/javascript'>"
        . "document.fr.submit();"
        . "</script>";
    }
    else
        echo "Consecutivo no existe";
} 
?>