<?php
	require_once 'conecta.php';
	require 'clase-email.php';

	class Usuario{
		protected $conn = null;
		protected $email;
		protected $usuario;
		protected $pass;
		protected $estado;
		protected $codigo;

		public function __construct(){
			$this->conn=conecta::conectar();
		}

		public function usuarioExiste($usuario){
			$query = ("CALL usuarioExiste('".$usuario."')");
			$usuarioExiste = $this->conn->query($query);
			if($usuarioExiste->rowCount() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function emailExiste($email){
			$query = ("CALL emailExiste('".$email."')");
			$emailExiste = $this->conn->query($query);
			if($emailExiste->rowCount() > 0){
				return true;
			}else{
				return false;
			}
		}		

		public function crearUsuario($email,$usuario,$password){
			$codigo = bin2hex(openssl_random_pseudo_bytes(21));
			$estado = 2;
			$clave1 = password_hash($password, PASSWORD_DEFAULT);

			try{
				$query = ("CALL crearUsuario('".$email."','".$usuario."','".$clave1."',".$estado.",'".$codigo."')");
				$crearUsuario = $this->conn->query($query);
				$success = $crearUsuario->rowCount();
				if($success>0){
					$this->email = $email;
					$this->usuario = $usuario;
					$this->codigo = $codigo;

					$valida = new Valida($email,$usuario,$codigo);
					$valida->sendValidationEmail();
					return true;
				}else if($success == false or $success == 0){
					return false;
				}
			}catch(PDOException $pe){
				die("No se puede conectar a la base de datos!".$pe->getMessage());
			}
		}

		public function consultarEstado($usuario){
			$query = "CALL consultarEstado('".$usuario."');";
			$respuesta = $this->conn->query($query);
			$estado = $respuesta->fetchColumn();
			if($estado==2 or $estado==3){
				return false;
			}else{
				return true;
			}
		}

		public function validarEmail($codigo){
			try{
				$query = "CALL validarEmail('".$codigo."');";
				$respuesta = $this->conn->query($query);
				if($respuesta->rowCount()>0){		
					return true;
				}else if($respuesta->rowCount() == 0 or $respuesta == false){
					return false;
				}
			}catch(PDOException $pe){
				die("No se puede conectar a la base de datos!".$pe->getMessage());
			}
		}

		public function iniciarSesion($usuario,$pass){
			try{
				$query = "CALL iniciarSesion('".$usuario."');";
				$respuesta = $this->conn->query($query);
				if($respuesta->rowCount() == 0 or $respuesta == false){
					return false;
				}else if($respuesta->rowCount()>0){
					$clave1 = $respuesta->fetch()[0];
					if(password_verify($pass, $clave1)){
						return true;
					}else{
						return false;
					}					
				}
			}catch(PDOException $pe){
				die("No se puede conectar a la base de datos!".$pe->getMessage());
			}
		}

		public function olvidoPassword($email){
			try{
				$codigo = bin2hex(openssl_random_pseudo_bytes(21));
				$query = "CALL olvidoPassword('".$codigo."','".$email."');";
				$respuesta = $this->conn->query($query);
				if($respuesta->rowCount() == 0 or $respuesta == false){
					return false;
				}else if($respuesta->rowCount()>0){
					$valida = new Valida($email,"Usuario de diestroChat",$codigo);
					$valida->sendRecoveryEmail();
					return true;				
				}
			}catch(PDOException $pe){
				die("No se puede conectar a la base de datos!".$pe->getMessage());
			}
		}

		public function validarCodigo($codigo){
			try{
				$query = "CALL validarCodigo('".$codigo."');";
				$respuesta = $this->conn->query($query);
				if($respuesta->rowCount()>0){		
					return true;
				}else if($respuesta->rowCount() == 0 or $respuesta == false){
					return false;
				}
			}catch(PDOException $pe){
				die("No se puede conectar a la base de datos!".$pe->getMessage());
			}
		}

		public function cambiarPassword($pass,$usuario,$codigo,$email){
			try{
				$clave1 = password_hash($pass, PASSWORD_DEFAULT);
				$query = "CALL cambiarPassword('".$clave1."','".$usuario."','".$codigo."','".$email."');";
				$respuesta = $this->conn->query($query);
				if($respuesta->rowCount()>0){		
					return true;
				}else if($respuesta->rowCount() == 0 or $respuesta == false){
					return false;
				}				
			}catch(PDOException $pe){
				die("No se puede conectar a la base de datos!".$pe->getMessage());
			}
		}

		public function mostrarInformacion($usuario){
			try{
				$query = "CALL mostrarInformacion('".$usuario."');";
				$respuesta = $this->conn->query($query);
				if($respuesta->rowCount()>0){
					$datos = $respuesta->fetchAll(PDO::FETCH_ASSOC);
					foreach ($datos as $dato){
						echo "<dt><h3>nombre de usuario:</h3></dt><br>
							<dd><h1>".$datos[0]["usuario"]."</h1></dd><br>
							<dt><h3>correo electrónico:</h3></dt><br>
							<dd><h2>".$datos[0]["email"]."</h2></dd><br>
							<dt><h4><a href='olvido-pass.html' target='_blank'>cambiar mi contraseña</a></h4></dt><br>";
					}
				}else if($respuesta->rowCount() == 0 or $respuesta == false){
					return false;
				}
			}catch(PDOException $pe){
				die("No se puede conectar a la base de datos!".$pe->getMessage());
			}	
		}

		public function mostrarInfoUsuario($usuario){
			try{
				$query = "CALL mostrarInformacion('".$usuario."');";
				$respuesta = $this->conn->query($query);
				if($respuesta->rowCount()>0){
					$datos = $respuesta->fetchAll(PDO::FETCH_ASSOC);
					foreach ($datos as $dato){
						echo "<dt><h3>nombre de usuario:</h3></dt><br>
							<dd><h1>".$datos[0]["usuario"]."</h1></dd><br>
							<dt><h3>correo electrónico:</h3></dt><br>
							<dd><h2>".$datos[0]["email"]."</h2></dd><br>";
						return true;
					}
				}else if($respuesta->rowCount() == 0 or $respuesta == false){
					return false;
				}
			}catch(PDOException $pe){
				die("No se puede conectar a la base de datos!".$pe->getMessage());
			}
		}

		public function buscarUsuarios($usuario){
			try{
				$query = "CALL buscarUsuarios('%".$usuario."%');";
				$respuesta = $this->conn->query($query);
				if($respuesta->rowCount()>0){
					$usuarios = $respuesta->fetchAll(PDO::FETCH_ASSOC);
					foreach($usuarios as $usu){
						$usuarioIterado = $usu["usuario"];
						echo "<dt><form id='".$usu["usuario"]."' action='php/almacenar-usuario.php' method='POST'><input type='hidden' name='usuarioRecibe' id='usuarioRecibe' value='".$usu["usuario"]."'><h1 class='resultadoBusqueda' onclick='almacenarUsuarioBuscar(\"$usuarioIterado\")'>".$usu["usuario"]."</h1></form></dt>";
					}
					die();
				}else if($respuesta->rowCount() == 0 or $respuesta == false){
					return false;
				}
			}catch(PDOException $pe){
				die("No se puede conectar a la base de datos!".$pe->getMessage());
			}
		}			
	}
?>