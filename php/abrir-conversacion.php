<?php
session_start();
require_once 'clase-mensaje.php';

if(empty($_SESSION["usuarioEnvia"]) or empty($_POST["usuarioRecibe"])){
	header("Location:http://urlejemplo/error.html");
	die();	
}

$usuarioEnvia = $_SESSION["usuarioEnvia"];
$usuarioRecibe = $_POST["usuarioRecibe"];

$mensaje = new Mensaje();
$mensaje->abrirConversacion($usuarioEnvia,$usuarioRecibe);
?>