<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/login/login.class.php";
$login=new login();
$login->inicia("hc");

if (!isset($_POST['id']))
    header("Location: /hc");

require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";
$paciente = ejecutarSql("SELECT * FROM `pacientes` WHERE `Tipo_ID`='{$_POST['tipoid']}' AND `ID`='{$_POST['id']}'");
$paciente = $paciente->fetch_assoc();
?>
<!DOCTYPE html>
<html class="<?php echo $_SESSION['tema']; ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <title>SIGMA HC - <?php echo $_POST['nombre']; ?></title>
        <link rel="stylesheet" href="/css/general.css">
        <link rel="stylesheet" href="/css/hc.css">
        <link rel="stylesheet" href="/css/atencion.css">
        <link rel="stylesheet" href="/css/cargando.css">
        <script type="text/javascript" src="/funciones/post.js"></script>
        <script type="text/javascript" src="/funciones/cargar.hc.js"></script>
    </head>
    <body onbeforeunload="return preguntar();">
        <?php require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/plantilla.menu.php"; ?>
        <div class="caja">
            <div class="encabezado" id="encabezado"></div>
            <div id="historia" class="historia"></div>
        </div>
        <script type="text/javascript">
            <?php
            $edad = date_diff(date_create($paciente['Fecha_Nacimiento']), date_create(date()))->y;
            $edad_genero_gs = implode(" / ", array_filter(array(
                "$edad a&ntilde;os",
                ucfirst(strtolower($paciente['Genero'])),
                $paciente['Grupo_Sanguineo']
            )));
            $profesional = ejecutarSql("SELECT * FROM `usuarios` WHERE `Usuario`='{$_SESSION['usr']}'");
            $profesional = $profesional->fetch_assoc();

            $dat = [
                'nombre' => "{$paciente['Nombres']} {$paciente['Apellidos']}",
                'id' => "{$paciente['Tipo_ID']} {$paciente['ID']}",
                'edad_genero_gs' => $edad_genero_gs,
                'profesional' => "{$profesional['Nombres']} {$profesional['Apellidos']}",
                'especialidad' => $profesional['Especialidad'],
                'registro' => $profesional['Registro'],
                'eps' => $paciente['EPS'],
                'afiliacion' => $paciente['Afiliacion'],
                'alerta' => $paciente['Alertas']
            ];
            ?>
            var _ANEXOS = <?php echo json_encode(ANEXOS, JSON_PRETTY_PRINT); ?>;
            var _TIPOSATENCION = <?php echo json_encode(TIPOSATENCION, JSON_PRETTY_PRINT); ?>;
            var dat = <?php echo json_encode($dat, JSON_PRETTY_PRINT); ?>;
            info_atencion(dat);
        </script>
        <div class="atenciones">
            <div class="flecha noseleccion">
                ATENCIONES
            </div>
            <div class="contenido">
                <table class="pacientes" style="font-size: 9pt;">
                    <tr>
                        <td style="width: 35%;">Fecha</td>
                        <td>ID</td>
                        <td>Atenci&oacute;n</td>
                    </tr>
                    <?php
                    $atenciones = ejecutarSql("SELECT * FROM `historias`"
                    . " WHERE `PacienteTipoId`='{$_POST['tipoid']}' AND `PacienteId`='{$_POST['id']}'"
                    . " ORDER BY `Creacion` DESC");
                    
                    if ($atenciones->num_rows > 0) {
                        while ($row = $atenciones->fetch_assoc()) {
                            $color = "";
                            $fecha = date('d-m-Y<\b\r>h:i a', strtotime($row['Creacion']));
                            if ($row['Firma'] === NULL)
                                $color = "style='color: red;'";

                            $firmado = $row['Firma'] === NULL ? 'Pendiente de firma' : 'Firmado';
                            
                            $profesional = ejecutarSql("SELECT * FROM `usuarios` WHERE `Usuario`='{$row['UsuarioCreacion']}'");
                            $profesional = $profesional->fetch_assoc();

                            $str_consecutivo = sprintf("%04d", $row['Consecutivo']);
 
                            echo "<tr $color onClick=\"cargar_hc('{$row['Consecutivo']}', '{$row['Carpeta']}', '$firmado');\">"
                            . "<td>$fecha</td><td>$str_consecutivo</td><td>" . CARPETAS[$row['Carpeta']] . "</td></tr>";

                            if ($_POST['consecutivo'] && $_POST['consecutivo'] == $row['Consecutivo']) {
                                echo "<script type='text/javascript'>
                                        cargar_hc('{$row['Consecutivo']}', '{$row['Carpeta']}', '$firmado');
                                    </script>";
                            }
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>