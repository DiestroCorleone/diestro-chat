<?php
require_once 'clase-usuario.php';

$usuario = new Usuario();

//Checkeamos que ninún campo esté vacío--------------
if(empty($_POST["email"]) or !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
	header("Location:http://urlejemplo/error.html");
	die();
}

$email = $_POST["email"];

if($usuario->olvidoPassword($email)){
	header("Location:http://urlejemplo/gracias.html");
}else{
	header("Location:http://urlejemplo/error.html");
	die();	
}
?>