<?php
session_start();
require_once 'clase-usuario.php';
$usuario = new Usuario();

if(empty($_SESSION["codigo_reset"]) or empty($_POST["email"]) or !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) or empty($_POST["pass"]) or empty($_POST["pass2"])){
	header("Location:http://urlejemplo/error.html");
	die();
	if($_POST["pass"] != $_POST["pass2"]){
		header("Location:http://urlejemplo/error.html");
		die();
	}			
}

$user = $_POST["usuario"];
$email = $_POST["email"];
$pass = $_POST["pass"];
$codigo = $_SESSION["codigo_reset"];

if($usuario->cambiarPassword($pass,$user,$codigo,$email)){
	header("Location:http://urlejemplo/actualizada.html");
}else{
	header("Location:http://urlejemplo/error.html");
	die();	
}
?>	