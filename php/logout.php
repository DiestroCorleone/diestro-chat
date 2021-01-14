<?php
session_start();
session_destroy();
unset($_SESSION["usuarioEnvia"]);
unset($usuarioEnvia);
header("Location:http://urlejemplo/index.html");
die();
?>