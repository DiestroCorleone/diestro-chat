<?php
session_start();
require_once 'clase-mensaje.php';

if(empty($_SESSION["usuarioEnvia"]) or empty($_POST["mensaje"]) or empty($_POST["usuarioRecibe"])){
	header("Location:http://urlejemplo/error.html");
	die();
}

$usuarioEnvia = $_SESSION["usuarioEnvia"];
$msj = $_POST["mensaje"];
$usuarioRecibe = $_POST["usuarioRecibe"];

$mensaje = new Mensaje();

if(!$mensaje->enviarMensajeConversacion($usuarioEnvia,$msj,$usuarioRecibe)){
	return false;	
}
?>