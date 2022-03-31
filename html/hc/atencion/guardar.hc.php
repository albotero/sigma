<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";
?>
<!DOCTYPE html>
<html class="<?php echo $_SESSION['tema']; ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/css/guardar.hc.css">
    </head>
    <body>
        <div class="caja">
            <?php
            $ruta = "{$_SERVER['DOCUMENT_ROOT']}/../../Atenciones/{$_SESSION['ips']}/{$_POST['d']}/{$_POST['c']}";
            $datos = $_POST['datos'];
            $tipo = $_POST['tipo'];

            if(isset($_POST['firmar'])) {
                // Agrega la firma al archivo     
                $datos[$tipo]['firma'] = [
                    'profesional' => $_SESSION['usr'],
                    'fecha' => date('d-m-Y h:i a')
                ];

                // Actualiza la firma en la base de datos
                ejecutarSql("UPDATE `historias`"
                . " SET `Firma`='" . date('Y-m-d H:i:s') . "',`UsuarioFirma`='{$_SESSION['usr']}'"
                . " WHERE `Consecutivo`='{$_POST['c']}'");
            }

            // Guarda el archivo
            $arr_file = [
                'paciente' => $_POST['paciente'],
                $tipo => $datos[$tipo]
            ];
            foreach ($_POST as $key => $arr) {
                if (is_array($arr) && $key != 'paciente' && $key != 'datos') {
                    $arr_file[$key] = $arr;
                }
            }
            $guardar_archivo = file_put_contents(
                $ruta,
                json_encode($arr_file, JSON_PRETTY_PRINT),
                LOCK_EX
            );

            // Muestra el resultado
            if ($guardar_archivo) {
                echo "<script type='text/javascript'>parent._hcAbierta = false;</script>";
                if (!isset($_POST['recargar'])) {
                    echo "<p>Se " . (isset($_POST['guardar']) ? 'guard' : 'firm') . "&oacute; la historia exitosamente.</p>";
                } else {
                    echo "<p>Se est&aacute; actualizando la Atenci&oacute;n</p>";
                }
            }
            else
            {
                echo "<p style='color: red;'>Ocurri&oacute; un error al guardar la historia.</p>";
                // Borra la firma en la base de datos
                ejecutarSql("UPDATE `historias` SET `Firma`=NULL,`UsuarioFirma`=NULL WHERE `Consecutivo`='{$_POST['c']}'");
            }
            ?>
            <script type="text/javascript">
                <?php
                if (!isset($_POST['recargar'])) {
                    echo "parent.postPage('{$_POST['paciente']['Tipo_ID']}', '{$_POST['paciente']['ID']}',
                        '{$_POST['paciente']['Nombres']} {$_POST['paciente']['Apellidos']}');";
                }
                else {
                    echo "window.location = window.frameElement.src + '&r=" . urlencode($_POST['recargar']) . "';";
                }
                ?>
            </script>
        </div>
    </body>
</html>