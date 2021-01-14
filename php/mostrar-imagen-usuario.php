<?php
session_start();
require_once 'clase-subir.php';

if(empty($_SESSION["usuarioRecibe"])){
	echo "Buscar usuarios";
	die();
}

$usuarioRecibe = $_SESSION["usuarioRecibe"];

$subir = new Subir();
$subir->mostrarImagenUsuario($usuarioRecibe);
?>