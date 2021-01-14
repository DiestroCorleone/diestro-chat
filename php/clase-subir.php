<?php
	require_once 'conecta.php';
	
	class Subir{
		public function __construct(){
			$this->conn=conecta::conectar();
		}

		public function subirImagen($imagen,$carpeta,$usuario){
			//Obtener ruta archivo
			$imagenDestino = $carpeta.basename($imagen["name"]);
			//Obtener extensión archivo
			$extension = strtolower(pathinfo($imagenDestino, PATHINFO_EXTENSION));
			//Tipos permitidos
			$tiposPermitidos = array("jpg","jpeg","png");

			if(!file_exists($imagen["tmp_name"])){
				return false;
			}else if(!in_array($extension, $tiposPermitidos)){
				return false;
			}else if($imagen["size"]>2097152){
				return false;
			}else if(file_exists($imagenDestino)){
				return false;
			}else{
				if(move_uploaded_file($imagen["tmp_name"], "../".$imagenDestino)){
					$query = "CALL subirImagenPerfil('".$usuario."','".$imagenDestino."');";
					$respuesta = $this->conn->query($query);
					if($respuesta->rowCount()>0){
						return true;
					}else if($respuesta == false or $respuesta->rowCount() == 0){
						return false;
					}
				}
			}
		}

		public function mostrarImagenPerfil($usuario){
			$query = "CALL mostrarImagenPerfil('".$usuario."')";
			$respuesta = $this->conn->query($query);
			if($respuesta->rowCount()>0){
				$imagen = $respuesta->fetchColumn();
				echo "<img src='".$imagen."'><br></a>
					<form action='php/subir-imagen-perfil.php' enctype='multipart/form-data' method='POST'>
					<a href=#actualizarImagenPerfil><p>cambiar imagen de perfil</p></a>
					<div id='actualizarImagenPerfil'><br>
					<input type='file' name='imagen' id='imagen' required><br><br>	
					<input type='submit' value='Subir'><i class='fa fa-fw fa-upload'></i></div></form>";
			}else if($respuesta == false or $respuesta->rowCount() == 0){
				echo "<form action='php/subir-imagen-perfil.php' enctype='multipart/form-data' method='POST'><p>No hay imagen de perfil. Subí una!<br><br><input type='file' name='imagen' id='imagen' required><br><br><input type='submit' value='Subir'><i class='fa fa-fw fa-upload'></i></p></form>";
			}
		}

		public function mostrarImagenUsuario($usuario){
			$query = "CALL mostrarImagenPerfil('".$usuario."')";
			$respuesta = $this->conn->query($query);
			if($respuesta->rowCount()>0){
				$imagen = $respuesta->fetchColumn();
				echo "<img src='".$imagen."'>";
			}else if($respuesta == false or $respuesta->rowCount() == 0){
				echo "<p><br>No hay imagen de perfil.<br><br></p>";
			}
		}		
	}
?>