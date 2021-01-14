<?php
session_start();
require_once 'clase-usuario.php';

if(empty($_SESSION["usuarioRecibe"])){
	echo "<form method='POST' action='javascript:buscarUsuarios();'>
		<input type='text' name='usuarioABuscar' id='usuarioABuscar' maxlength='20' placeholder='nombre de usuario a buscar...'><br><br>
		<input type='submit' value='Buscar usuario'>
		</form>";
	die();
}

$usuarioRecibe = $_SESSION["usuarioRecibe"];

$usuario = new Usuario();
$usuario->mostrarInfoUsuario($usuarioRecibe);
?>