<?php
function javaScript($codigo) {
    return "\n<script type='text/javascript'>$codigo</script>";
}

function alert($msg) {
    echo javaScript("alert('$msg');");
}

function redirect($url, $timeout=0) {
    echo javaScript("setTimeout(function () { window.location.href= '/$url'; }, $timeout);");
}
?>