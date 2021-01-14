<?php
session_start();
require_once 'clase-usuario.php';

if(empty($_SESSION["usuarioEnvia"])){
	header("Location:http://urlejemplo/error.html");
	die();	
}

$usuarioEnvia = $_SESSION["usuarioEnvia"];

$usuario = new Usuario();
$usuario->mostrarInformacion($usuarioEnvia);
?>