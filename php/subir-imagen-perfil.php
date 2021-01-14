<?php
session_start();
require_once 'clase-subir.php';

if(empty($_FILES["imagen"]) or empty($_SESSION["usuarioEnvia"])){
	header("Location:http://urlejemplo/error.html");
	die();
}

$imagen = $_FILES["imagen"];
$carpeta = "user-img/";
$usuario = $_SESSION["usuarioEnvia"];

$subir = new Subir();
if($subir->subirImagen($imagen,$carpeta,$usuario)){
	echo "<script>alert('Archivo subido correctamente');window.location.replace('http://urlejemplo/profile.php');</script>";
}else{
	header("Location:http://urlejemplo/error.html");
	die();	
}
?>