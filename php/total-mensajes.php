<?php
session_start();
require_once 'clase-mensaje.php';

if(empty($_SESSION["usuarioEnvia"])){
	header("Location:http://urlejemplo/error.html");
	die();	
}

$usuarioEnvia = $_SESSION["usuarioEnvia"];

$mensaje = new Mensaje();
echo $mensaje->totalMensajes($usuarioEnvia);
?>