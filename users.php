<?php
session_start();
$usuarioEnvia = $_SESSION["usuarioEnvia"];
if(!empty($_SESSION["usuarioRecibe"])){
	$usuarioRecibe = $_SESSION["usuarioRecibe"];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#222831">
	<script src="control.js"></script>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>usuarios | diestroChat</title>
</head>
<body class="profileBody" onload="mostrarInfoUsuario();mostrarImagenUsuario();">
<nav id="homeNav">
	<ul>
		<a><li id="logoNav">diestroChat<i class="fa fa-fw fa-commenting-o" id="logo"></i></li></a>
		<a href="home.php"><li><i class="fa fa-fw fa fa-comments"></i><span class="desaparece">mensajes</span></li></a>
		<a onclick="eliminarUsuarioAlmacenado();" class="pointer"><li><form id="navForm" method="POST" action="php/eliminar-usuario-almacenado.php"></form><i class="fa fa-fw fa-address-card"></i><span class="desaparece">usuarios</span></li></a>
		<a href="profile.php"><li><i class="fa fa-fw fa-user"></i><span class="desaparece">mi perfil</span></li></a>
		<a href="php/logout.php" onclick="return confirm('Seguro que deseás salir?')"><li><i class="fa fa-fw fa-sign-out"></i><span class="desaparece">cerrar sesión</span></li></a>
	</ul>
</nav>
<section>
	<div id="imagenPerfil"></div><br>
	<dl id="informacion">
	</dl>
</section>
<footer>
	<p>Coded by Diestro<br><a href="mailto:matias.perez.mcd@gmail.com">Mail me!</a></p>
</footer>	
</body>
</html>