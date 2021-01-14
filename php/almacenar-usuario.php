<?php
session_start();
require_once 'clase-usuario.php';

if(empty($_POST["usuarioRecibe"])){
	header("Location:http://urlejemplo/error.html");
	die();	
}else{
	$_SESSION["usuarioRecibe"] = $_POST["usuarioRecibe"];
	header("Location:http://urlejemplo/users.php");	
}	
?>