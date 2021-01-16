<?php
session_start();
$usuarioEnvia = $_SESSION["usuarioEnvia"];
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
	<title>home | diestroChat</title>
</head>
<body class="homeBody" onload="mostrarConversaciones();checkForUpdates();">
<nav id="homeNav">
	<ul>
		<a><li id="logoNav">diestroChat<i class="fa fa-fw fa-commenting-o" id="logo"></i></li></a>
		<a href="#nuevoMensaje"><li><i class="fa fa-fw fa-edit"></i><span class="desaparece">nuevo mensaje</span></li></a>
		<a onclick="eliminarUsuarioAlmacenado();" class="pointer"><li><form id="navForm" method="POST" action="php/eliminar-usuario-almacenado.php"></form><i class="fa fa-fw fa-address-card"></i><span class="desaparece">usuarios</span></li></a>
		<a href="profile.php"><li><i class="fa fa-fw fa-user"></i><span class="desaparece">mi perfil</span></li></a>
		<a href="php/logout.php" onclick="return confirm('Seguro que deseás salir?')"><li><i class="fa fa-fw fa-sign-out"></i><span class="desaparece">cerrar sesión</span></li></a>
	</ul>
</nav>
<aside class="scrollable" id="historialConversaciones">
	<h1>conversaciones</h1><br>
	<ul id="conversaciones">
		<li><a href='#historialConversaciones'><article><p>conversaciones</p></article></a></li><br>
		<li id="cerrarConversaciones"><a href='#'><article><p>x</p></article></a></li><br>
	</ul>	
</aside>
<section id="nuevoMensajeConversacion">
	<ul id="conversacion" class="scrollable">
	</ul>
	<form action="javascript:enviarMensajeConversacion();" id="formConversacion" class="invisible" onload="ocultarForm();">
		<textarea name="mensaje" id="mensajeConversacion" maxlength="500" rows="1" placeholder="escribí tu mensaje..." class="homeBodyInput"></textarea>
		<input type="submit" value="enviar" class="homeBodyInput">
	</form>
</section>
<section id="nuevoMensaje">	
	<form action="javascript:enviarMensaje();" class="noMarginTop homeBodyInput">
		<input type="text" name="usuarioRecibe" id="usuarioRecibe" placeholder="para..." class="homeBodyInput"><br><br>
		<textarea name="mensaje" id="mensaje" maxlength="500" placeholder="escribí tu mensaje..." class="homeBodyInput"></textarea><br><br>
		<input type="submit" value="enviar" class="homeBodyInput">
	</form>
</section>
<footer>
	<p>Coded by Diestro<br><a href="mailto:matias.perez.mcd@gmail.com">Mail me!</a></p>
</footer>	
</body>
</html>