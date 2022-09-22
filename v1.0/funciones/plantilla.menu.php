<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/funciones/constantes.php";
?>
<link rel="stylesheet" href="/css/menu.css">
<link rel="stylesheet" href="/css/modal.css">
<script type="text/javascript">
    const _horaInicial = new Date('<?php echo date('Y-m-d\TH:i:s'); ?>');
</script>
<div id="menuboton" onclick="this.classList.toggle('change');">
  <div class="barra"></div>
</div>
<nav class="noseleccion">
    <ul class="contenedor">
        <?php foreach($iconosMenu as $icono):
            if (isset($icono['grupo']) && strpos($_SERVER['PHP_SELF'], $icono['grupo']) === false):
            elseif ($icono['imgsrc'] === 'separador'): ?>
                <li class="menuseparador"></li>
            <?php else: ?>
            <li <?php if ($icono['id']) echo "id=\"{$icono['id']}\""; ?>>
                <div class="menuitem" <?php 
                    echo "titulo=\"{$icono['texto']}\"";
                    if (!is_array($icono['accion'])) echo "onclick=\"{$icono['accion']}\"";
                    ?>>
                <img src="/img/<?php echo $icono['imgsrc']; ?>" />
                <div class="desc"><?php echo $icono['texto']; ?></div>
                </div>
                <?php
                if (is_array($icono['accion']) || !$icono['accion']) {
                    echo "<ul class='desplegable'>";
                    foreach($icono['accion'] as $subitemTitulo => $subitemAccion) {
                        echo "<li onclick=\"$subitemAccion\">$subitemTitulo</li>";
                    }
                    echo "</ul>";
                }
                ?>
            </li>
            <?php endif;
        endforeach; ?>
        <div id="reloj"></div>
    </ul>
</nav>
<script type="text/javascript" src="/funciones/menu.js"></script>
<script type="text/javascript" src="/funciones/modal.js"></script>
<div id="modal"></div>
<div id="roller">
    <div class="lds-roller">
        <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
    </div>
</div>
<div id="infoversion" class="noseleccion">Sigma ver. 1.1-210601</div>