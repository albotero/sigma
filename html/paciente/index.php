<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/login/login.class.php";
$login=new login();
$login->inicia("hc/paciente");
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
        <title>SIGMA HC - Paciente</title>
        <link rel="stylesheet" href="/css/general.css">
        <link rel="stylesheet" href="/css/hc.css">
        <link rel="stylesheet" href="/css/formulario.css">
        <script type="text/javascript" src="/funciones/post.js"></script>
    </head>
    <body>
<?php
if (isset($_POST['datos'])):
    $datos = $_POST['datos'];
    require_once  "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";

    // CONFIRMA QUE NO EXISTA YA ESE PACIENTE
    $paciente = ejecutarSql("SELECT * FROM `pacientes`"
    . " WHERE `Tipo_ID`='{$datos['Tipo_ID']}' AND `ID`='{$datos['ID']}'");
    if ($paciente->num_rows > 0):
?>
        <link rel="stylesheet" href="/css/login.css">
        <div class="caja login">
            <p style="color: red;"><b>ERROR:</b>
            Ya existe un paciente con el mismo documento de identidad.
            No se puede sobreescribir.</p>
            <p><span onClick='history.go(-1);'>Volver</span></p>
        </div>
<?php
    else:
        // GUARDA LOS DATOS Y REDIRIGE A LA PAG HC CON LOS DATOS DEL PACIENTE QUE ACABO DE EDITAR
        $columnas = implode("`, `", array_keys($datos));
        $valores = implode("', '", array_values($datos));
        $valores = strtoupper($valores);
        $nombre = strtoupper($datos['Nombres'] . ' ' . $datos['Apellidos']);
        ejecutarSql("INSERT INTO `pacientes` (`$columnas`) VALUES ('$valores')");
        echo "<script type='text/javascript'>"
        . "postPage('{$datos['Tipo_ID']}', '{$datos['ID']}', '$nombre');"
        . "</script>";
    endif;
else:
        require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/plantilla.menu.php";
?>
        <form class="form-1" autocomplete="off" method="post">
            <div class="columnas">
                <fieldset>
                <legend><span class="number">1</span> Identificaci&oacute;n</legend>
                    <label for="ID" class="requerido">Documento de Identidad</label>
                    <select name="datos[Tipo_ID]" id="Tipo_ID" required>
                        <option hidden disabled selected value>--Seleccionar--</option>
                        <option value="CC">CC</option>
                        <option value="RC">RC</option>
                        <option value="TI">TI</option>
                        <option value="PA">PA</option>
                        <option value="CE">CE</option>
                        <option value="VEN">VEN</option>
                        <option value="OTRO">OTRO</option>
                    </select>
                    <input type="text" name="datos[ID]" id="ID" required />

                    <label for="Nombres" class="requerido">Nombres</label>
                    <input type="text" name="datos[Nombres]" id="Nombres" required />

                    <label for="Apellidos" class="requerido">Apellidos</label>
                    <input type="text" name="datos[Apellidos]" id="Apellidos" required />

                    <label for="Genero" class="requerido">G&eacute;nero</label>
                    <select name="datos[Genero]" id="Genero" required>
                        <option hidden disabled selected value>--Seleccionar--</option>
                        <option value="MASCULINO">MASCULINO</option>
                        <option value="FEMENINO">FEMENINO</option>
                    </select>
                
                    <label for="Fecha_Nacimiento" class="requerido">Fecha de Nacimiento</label>
                    <input type="date" name="datos[Fecha_Nacimiento]" id="Fecha_Nacimiento" placeholder="dd / mm / aaaa" required />
                
                    <label for="Grupo_Sanguineo">Grupo Sangu&iacute;neo</label>
                    <select name="datos[Grupo_Sanguineo]" id="Grupo_Sanguineo">
                        <option selected value>--Seleccionar--</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </fieldset>
                <div class="linea"></div>
                <fieldset>
                <legend><span class="number">2</span> Informaci&oacute;n</legend>
                    <label for="Estado_Civil">Estado Civil</label>
                    <select name="datos[Estado_Civil]" id="Estado_Civil">
                        <option selected value>--Seleccionar--</option>
                        <option value="SOLTERO">SOLTERO</option>
                        <option value="CASADO">CASADO</option>
                        <option value="UNION LIBRE">UNION LIBRE</option>
                        <option value="VIUDO">VIUDO</option>
                    </select>

                    <label for="Ocupacion">Ocupaci&oacute;n</label>
                    <input type="text" name="datos[Ocupacion]" id="Ocupacion" />

                    <label for="EPS" class="requerido">Aseguradora</label>
                    <input type="text" name="datos[EPS]" id="EPS" required />

                    <label for="Afiliacion">Tipo de Afiliaci&oacute;n</label>
                    <select name="datos[Afiliacion]" id="Afiliacion">
                        <option selected value>--Seleccionar--</option>
                        <option value="NO APLICA">NO APLICA</option>
                        <option value="COTIZANTE">COTIZANTE</option>
                        <option value="BENEFICIARIO">BENEFICIARIO</option>
                        <option value="SUBSIDIADO">SUBSIDIADO</option>
                    </select>

                    <label for="Emergencia_Nombre" class="requerido">Contacto de Emergencia</label>
                    <input type="text" name="datos[Emergencia_Nombre]" id="Emergencia_Nombre" required />

                    <label for="Emergencia_Telefono" class="requerido">Tel&eacute;fono de Emergencia</label>
                    <input type="text" name="datos[Emergencia_Telefono]" id="Emergencia_Telefono" required />
                </fieldset>
                <div class="linea"></div>
                <fieldset>
                <legend><span class="number">3</span> Contacto</legend>
                    <label for="Celular" class="requerido">Celular</label>
                    <input type="text" name="datos[Celular]" id="Celular" required />

                    <label for="Telefono">Tel&eacute;fono Fijo</label>
                    <input type="text" name="datos[Telefono]" id="Telefono" />

                    <label for="Email">Email</label>
                    <input type="text" name="datos[Email]" id="Email" />

                    <label for="Direccion">Direcci&oacute;n</label>
                    <input type="text" name="datos[Direccion]" id="Direccion" />

                    <label for="Ciudad">Ciudad / Depto. / Pa&iacute;s</label>
                    <input type="text" name="datos[Ciudad]" id="Ciudad" />

                    <input type="hidden" name="datos[Alertas]" />
                </fieldset>
            </div>
            <div class="botones">
                <input type="reset" class="boton" value="Limpiar" onclick="return confirm('Se borrarán todos los datos ingresados.\n¿Desea continuar?');" />
                <input type="submit" class="boton" value="Guardar"/>
            </div>
        </form>
    </body>
</html>
<?php endif; ?>