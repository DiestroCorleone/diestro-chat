<?php
require_once 'php/clase-usuario.php';
$usuario = new Usuario();

//Toma el código enviado mediante el método GET-------------
if(empty($_GET["codigo"])){
	header("Location:http://urlejemplo/error.html");
	die();
}

$codigo = $_GET["codigo"];

if($usuario->validarEmail($codigo)){
	header("Location:http://urlejemplo/validado.html");
}else{
	header("Location:http://urlejemplo/error.html");
	die();
}
?>