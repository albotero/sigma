<?php
if (!$_POST['id'])
    die('Sin datos');
else {
    require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/bd.class.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/ips.class.php";
    $ips = new ips();
?>
<html>
    <head>
        <title>Imprimir Atenci&oacute;n</title>
        <link rel="stylesheet" href="/css/formula.print.css">
    </head>
    <script type="text/javascript">
        window.onafterprint = function(){
            window.close();
        }
    </script>
    <body onload="window.focus(); window.print();">
        <div class="header">
            <table>
                <tr>
                    <td width="15%"><img src="<?php echo $ips->logo; ?>" alt="IPS" id="imgIPS" /></td>
                    <td width=""><div id="tituloips"><?php echo "{$ips->nombre}"; ?></div>
                        <div id="descips"><?php echo "{$ips->nit}<br />Tel. {$ips->telefono}"; ?></div></td>
                    <td width="50%"><table class="tablaDatos">
                        <tr>
                            <th colspan=2>Paciente</th>
                            <th>Fecha</th>
                        </tr>
                        <tr>
                            <td colspan=2><?php echo $_POST['nombre']; ?></td>
                            <td><?php echo $_POST['fechaatencion']; ?></td>
                        </tr>
                        <tr>
                            <th>Identificaci&oacute;n</th>
                            <th>Edad</th>
                            <th>Aseguradora</th>
                        </tr>
                        <tr>
                            <td><?php echo $_POST['id']; ?></td>
                            <td><?php echo $_POST['edad']; ?></td>
                            <td><?php echo $_POST['eps']; ?></td>
                        </tr>
                    </table></td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <table>
                <tr>
                    <td colspan=2 style="text-align: center;">
                        Firmado electr&oacute;nicamente
                    </td>
                </tr>
                <tr>
                    <td><img src="<?php echo $ips->firma; ?>" alt="Firma Electronica" id="imgFirma" /></td>
                    <td>
                        <?php echo $_POST['profesional']; ?><br />
                        <?php echo $_POST['especialidad']; ?><br />
                        Reg. <?php echo $_POST['registro']; ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="formula"><?php echo $_POST['html_med']; ?></div>
    </body>
</html>
<?php } ?>