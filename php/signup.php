<?php
require_once 'clase-usuario.php';

$usuario = new Usuario();

//Checkeamos que ninún campo esté vacío--------------
if(empty($_POST["usuario"]) or empty($_POST["email"]) or empty($_POST["pass"]) or !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) or strlen($_POST["pass"])<8 or strlen($_POST["usuario"])<4 or ($_POST["pass"] != $_POST["pass2"])){
	header("Location:http://urlejemplo/error.html");
	die();
}

$email = $_POST["email"];
$user = $_POST["usuario"];
$pass = $_POST["pass"];

if(!$usuario->usuarioExiste($user)){
	if(!$usuario->emailExiste($email)){
		if($usuario->crearUsuario($email,$user,$pass)){
			header("Location:http://urlejemplo/gracias.html");
			die();
		}else{
			header("Location:http://urlejemplo/error.html");
			die();
		}
	}else{
		header("Location:http://urlejemplo/existe.html");
		die();
	}	
}else{
	header("Location:http://urlejemplo/existe.html");
	die();	
}	
?>