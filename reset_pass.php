<?php
session_start();
require_once 'php/clase-usuario.php';
$usuario = new Usuario();

//Toma el código enviado mediante el método GET-------------
if(empty($_GET["codigo"])){
	header("Location:http://urlejemplo/error.html");
	die();
}

$codigo = $_GET["codigo"];
$_SESSION["codigo_reset"] = $codigo;

if($usuario->validarCodigo($codigo)){
	header("Location:http://urlejemplo/cambia-pass.html");
}else{
	header("Location:http://urlejemplo/error.html");
	die();
}
?>