<?php
session_start();
require_once 'clase-usuario.php';

if(empty($_SESSION["usuarioEnvia"])){
	header("Location:http://urlejemplo/error.html");
	die();
}

$usuarioABuscar = $_POST["usuarioABuscar"];
$usuario = new Usuario();
$resultado = $usuario->buscarUsuarios($usuarioABuscar);
if(!$resultado){
	echo "No se encontraron resultados!";
}else{
	echo $resultado;
}
?>