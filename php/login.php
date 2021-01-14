<?php
session_start();
require_once 'clase-usuario.php';

$usuario = new Usuario();

if(empty($_POST["usuario"]) or empty($_POST["pass"]) or strlen($_POST["usuario"])<4 or strlen($_POST["pass"])<8){
	header("Location:http://urlejemplo/error.html");
	die();
}

$user = $_POST["usuario"];
$pass = $_POST["pass"];

if($usuario->consultarEstado($user)){
	if(!$usuario->iniciarSesion($user,$pass)){
		header("Location:http://urlejemplo/error.html");
		die();	
	}else{
		$_SESSION["usuarioEnvia"] = $user;
		header("Location:http://urlejemplo/home.php");
	}
}else{
	header("Location:http://urlejemplo/sin-validar.html");	
}
?>