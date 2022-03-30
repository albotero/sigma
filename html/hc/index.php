<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/login/login.class.php";
$login=new login();
$login->inicia("hc");
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
        <title>SIGMA HC</title>
        <link rel="stylesheet" href="/css/general.css">
        <link rel="stylesheet" href="/css/hc.css">
        <link rel="stylesheet" href="/css/cargando.css">
    </head>
    <body>
        <?php require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/plantilla.menu.php"; ?>        
        <div class="caja buscar">
            <div class="titulo noseleccion">
                <p>Buscar pacientes</p>
            </div>
            <form autocomplete="off">
                <table>
                    <tr>
                        <td>Identificaci&oacute;n:<br /><input name="i" id="i" type="text" pattern="[0-9a-zA-Z\-]*"
                            <?php if (isset($_GET['i'])) echo "value='{$_GET['i']}'" ?>
                            /></td>
                        <td>Nombres:<br /><input name="n" id="n" type="text"
                            <?php if (isset($_GET['n'])) echo "value='{$_GET['n']}'" ?>
                            /></td>
                        <td>Apellidos:<br /><input name="a" id="a" type="text"
                            <?php if (isset($_GET['a'])) echo "value='{$_GET['a']}'" ?>
                            /></td>
                        <td><input type="submit" value="Buscar" class="boton"
                            onclick="document.getElementById('roller').style.display = 'block';" /></td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="ventana">
            <?php
            if(isset($_GET['i']) || isset($_GET['n']) || isset($_GET['a'])) {
                // Le dio clic al botón de Buscar
                // Busca todo y si encuentra pacientes los pone en la tabla
                require_once $_SERVER['DOCUMENT_ROOT'] . "/funciones/bd.class.php";
                $comando = "SELECT * FROM `pacientes` WHERE";
                if (isset($_GET['i']))
                    $comando .= " ( `ID` LIKE '%{$_GET['i']}%' )";
                if (isset($_GET['n']))
                    $comando .= " AND ( `Nombres` LIKE '%{$_GET['n']}%' )";
                if (isset($_GET['a']))
                    $comando .= " AND ( `Apellidos` LIKE '%{$_GET['a']}%' )";
                $comando .= " ORDER BY `Nombres` ASC";
                
                $maxResultados = 8;
                $countResultados = ejecutarSql($comando)->num_rows;
                $listaPacientes = ejecutarSql($comando .
                    " LIMIT $maxResultados OFFSET " .
                    (isset($_GET['p']) ? ($_GET['p'] - 1) * $maxResultados : 0));

                if ($listaPacientes->num_rows > 0):
            ?>
            <div class="pacientes caja">
                <script type="text/javascript" src="/funciones/post.js"></script>
                <table class="pacientes noseleccion">
                    <tr><td>Nombres</td><td>Apellidos</td><td>Identificaci&oacute;n</td><td>Edad</td><td>G&eacute;nero</td></tr>
                    <?php
                    while($row = $listaPacientes->fetch_assoc()) {
                        $edad = date_diff(date_create($row['Fecha_Nacimiento']), date_create('now'))->y;
                        echo "<tr onclick=\"document.getElementById('roller').style.display = 'block';"
                        . "postPage('{$row['Tipo_ID']}', '{$row['ID']}', "
                        . "'{$row['Nombres']} {$row['Apellidos']}');\">"
                        . "<td>{$row['Nombres']}</td><td>{$row['Apellidos']}</td>"
                        . "<td>{$row['Tipo_ID']} {$row['ID']}</td>"
                        . "<td>$edad A&Ntilde;OS</td><td>{$row['Genero']}</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="paginas">
                <?php
                if ($countResultados > $maxResultados) {
                    for ($i = 1; $i <= ceil($countResultados / $maxResultados); $i++) {
                        $link = explode( '?', $_SERVER['REQUEST_URI'] )[0] .
                            "?i={$_GET['i']}&n={$_GET['n']}&a={$_GET['a']}&p=$i";
                        echo ($i > 1 ? " - " : "") . "<a onclick='window.location = \"$link\"'>$i</a>";
                    }
                }
                ?>
            </div>
            <?php else: ?>
            <div class="pacientes caja error">
                <p style="color: red;"><b>ERROR:</b> ¡No se encontraron coincidencias!</p>
            </div>
            <?php endif;
            }
            ?>
        </div>
    </body>
</html>