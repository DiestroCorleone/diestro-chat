<?php
session_start();
$usuarioRecibe = null;
$_SESSION["usuarioRecibe"] = null;
header("Location:http://urlejemplo/users.php");
?>