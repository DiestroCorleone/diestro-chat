<?php
session_start();
$usuarioEnvia = $_SESSION["usuarioEnvia"];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<html lang="es">
	<meta name="description" content="Diestro Chat es la plataforma de mensajería instantánea que buscabas! Simple, segura, y respeta tu privacidad. Disponible para escritorio, Android y iOS. Registrate ya, es gratis!">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#222831">
	<script src="control.js"></script>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel = "icon" href = "img/favicon.ico" size = "32x32" type = "image/ico">
	<link rel="apple-touch-icon" href="img/icon-sm.png">
	<title>perfil | diestroChat</title>
</head>
<body class="profileBody" onload="mostrarInformacion();mostrarImagenPerfil();checkearMensajeNuevo();">
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