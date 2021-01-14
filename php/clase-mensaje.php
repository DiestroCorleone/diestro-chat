<?php
require_once 'conecta.php';

class Mensaje{
	protected $conn = null;
	protected $mensaje;
	protected $usuarioEnvia;
	protected $id;

	public function __construct(){
		$this->conn=conecta::conectar();
	}

	public function enviarMensaje($usuarioEnvia,$mensaje,$usuarioRecibe){
		try{
			if($usuarioEnvia == $usuarioRecibe){
				return false;
			}
			$query = "CALL enviarMensaje('".$usuarioEnvia."','".$mensaje."','".$usuarioRecibe."');";
			$respuesta = $this->conn->query($query);
			if($respuesta == false or $respuesta->rowCount() == 0){
				return false;
			}else if($respuesta->rowCount()>0){
				echo "<li><a><article>
						<p>conversación con ".$usuarioRecibe."</p>
					</article></a></li><br>";
				return true;
			}
		}catch(PDOException $pe){
			die("No se puede conectar a la base de datos!".$pe->getMessage());
		}
	}

	public function mostrarConversaciones($usuarioEnvia){
		try{
			$query = "CALL mostrarConversaciones('".$usuarioEnvia."');";
			$respuesta = $this->conn->query($query);
			if($respuesta == false or $respuesta->rowCount() == 0){
				echo "No hay conversaciones.";
				return false;
			}else if($respuesta->rowCount()>0){
				$conversaciones = $respuesta->fetchAll(PDO::FETCH_ASSOC);
				foreach($conversaciones as $i){
					foreach ($i as $key => $value){
						echo "<li onclick='abrirConversacion(\"$value\")'><a href='#nuevoMensajeConversacion'><article>
						<p>conversación con ".$value."</p>
					</article></a></li><br>";
					}					
				}			
				return true;
			}		
		}catch(PDOException $pe){
			die("No se puede conectar a la base de datos!".$pe->getMessage());
		}
	}

	public function abrirConversacion($usuarioEnvia,$usuarioRecibe){
		try{
			$query = "CALL abrirConversacion('".$usuarioEnvia."','".$usuarioRecibe."');";
			$respuesta = $this->conn->query($query);
			if($respuesta == false or $respuesta->rowCount() == 0){
				echo "No hay mensajes.";
				return false;
			}else if($respuesta->rowCount()>0){
				$conversacion = $respuesta->fetchAll(PDO::FETCH_ASSOC);
				echo "<form id='formTituloConversacion' action='php/almacenar-usuario.php' method='POST'><input type='hidden' name='usuarioRecibe' id='usuarioRecibe' value='".$usuarioRecibe."'></form><h2 class='tituloConversacion' onclick='almacenarUsuario()'>".$usuarioRecibe."</h2>";
				foreach($conversacion as $chat){
					if($chat['ue'] == $usuarioEnvia){
						echo "<li><article class='mensajeEnviado'>";
					}else{
						echo "<li><article class='mensajeRecibido'>";
					}					
					echo "<p>".$chat['mensaje']."</p>
						<p><small>".$chat['fecha_envio']."</small></p>
					</article><br></li>";
				}
				echo "<span id='finalConversacion'></span>";
			}
		}catch(PDOException $pe){
			die("No se puede conectar a la base de datos!".$pe->getMessage());
		}
	}

	public function enviarMensajeConversacion($usuarioEnvia,$mensaje,$usuarioRecibe){
		try{
			if($usuarioEnvia == $usuarioRecibe){
				return false;
			}
			$query = "CALL enviarMensaje('".$usuarioEnvia."','".$mensaje."','".$usuarioRecibe."');";
			$respuesta = $this->conn->query($query);
			if($respuesta == false or $respuesta->rowCount() == 0){
				return false;
			}else if($respuesta->rowCount()>0){
				echo "<li><a><article class='mensajeEnviado'>
						<p>".$mensaje."</p>
						<p><small>".date('Y-m-d H:i:s')."</p>
					</article></a></li><br>";
				return true;
			}
		}catch(PDOException $pe){
			die("No se puede conectar a la base de datos!".$pe->getMessage());
		}
	}	
}	
?>