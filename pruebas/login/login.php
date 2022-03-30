<?php
session_start();
$_SESSION['ips']=$_POST['ips'];
require_once "login.class.php";
$login=new login();
$login->inicia($_POST['ref'], 60*60*4, $_POST['usuario'], $_POST['contrasena']);
?>