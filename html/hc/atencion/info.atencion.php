<?php
session_start();
$decoded = json_decode(base64_decode($_POST['datos']), true)[$tipo_atencion];
$paciente = json_decode(base64_decode($_POST['paciente']), true);

require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/constantes.php";

// Si el archivo contiene datos del paciente los utiliza y si no deja los que pasó el POST
$cont_archivo = file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/../Atenciones/{$_SESSION['ips']}/{$_POST['d']}/{$_POST['c']}");
$cont_archivo = json_decode($cont_archivo, true);
if ($cont_archivo['paciente']) {
    $paciente = $cont_archivo['paciente'];
}
$alerta_caja = preg_replace("/\r\n|\r|\n/", '<br />', $paciente['Alertas']);
$alerta_caja = preg_replace("/\'/", '\\\'', $alerta_caja);

$fecha_creacion = date('d-m-Y h:i a');
if (isset($_POST['c'])) {
    // Si hay atenciones abiertas, coge la hora guardada
    // Si la fecha de creación no está en el archivo, la busca en la base de datos
    $fecha_creacion = $decoded['creacion'];
    if (!$fecha_creacion) {
        $historia = ejecutarSql("SELECT `Creacion` FROM `historias` WHERE `Consecutivo`='{$_POST['c']}'");
        $historia = $historia->fetch_assoc();
        $fecha_creacion = date('d-m-Y h:i a', strtotime($historia['Creacion']));
    }
}
$edad = date_diff(date_create($paciente['Fecha_Nacimiento']), date_create($fecha_creacion))->y;
$edad_genero_gs = implode(" / ", array_filter(array(
    "$edad a&ntilde;os",
    ucfirst(strtolower($paciente['Genero'])),
    $paciente['Grupo_Sanguineo']
)));

$profesional = $decoded['usuario'] ? $decoded['usuario'] : $_SESSION['usr'];
$profesional = ejecutarSql("SELECT * FROM `usuarios` WHERE `Usuario`='$profesional'");
$profesional = $profesional->fetch_assoc();
$dat = [
    'nombre' => "{$paciente['Nombres']} {$paciente['Apellidos']}",
    'id' => "{$paciente['Tipo_ID']} {$paciente['ID']}",
    'edad_genero_gs' => $edad_genero_gs,
    'consecutivo' => sprintf("%04d", $_POST['c']),
    'tipoatencion' => CARPETAS[$_POST['d']],
    'fechaatencion' => $fecha_creacion,
    'estadoatencion' => $decoded['firma'] ? 'Firmado' : 'Pendiente de firma',
    'profesional' => "{$profesional['Nombres']} {$profesional['Apellidos']}",
    'especialidad' => $profesional['Especialidad'],
    'registro' => $profesional['Registro'],
    'eps' => $paciente['EPS'],
    'afiliacion' => $paciente['Afiliacion'],
    'alerta' => $alerta_caja
];
?>
<script type="text/javascript">
    var dat = <?php echo json_encode($dat, JSON_PRETTY_PRINT); ?>;
    parent.info_atencion(dat);
</script>