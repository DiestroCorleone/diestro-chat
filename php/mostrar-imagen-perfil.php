<?php
session_start();
require_once 'clase-subir.php';

if(empty($_SESSION["usuarioEnvia"])){
	header("Location:http://urlejemplo/error.html");
	die();	
}

$usuarioEnvia = $_SESSION["usuarioEnvia"];

$subir = new Subir();
$subir->mostrarImagenPerfil($usuarioEnvia);
?>