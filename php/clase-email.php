<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'Exception.php';
	require 'PHPMailer.php';
	require 'SMTP.php';

	class Valida{
		protected $email;
		protected $usuario;
		protected $codigo;

		//En el constructor se asignan valores a las variables-----------
		public function __construct($email,$usuario,$codigo){
			$this->email = $email;
			$this->usuario = $usuario;
			$this->codigo = $codigo;
		}

		public function sendEmail($subject,$body){
			//----------------------------Empieza PHPMailer----------------------------------------------------
			$mail = new PHPMailer(true);
			try{
				$mail->setFrom('ejemplo@gmail.com', 'diestroChat');
				$mail->addAddress($this->email,$this->usuario);
				$mail->Subject = $subject;
				$mail->Body = $body;
				$mail->isSMTP();
   				$mail->Host = 'smtp.gmail.com';
   				$mail->SMTPAuth = TRUE;
  				$mail->SMTPSecure = 'tls';
   				$mail->Username = 'ejemplo@gmail.com';
   				$mail->Password = 'tu-contraseña';
   				$mail->Port = 587;
   				$mail->send();
			}catch (Exception $e){
   				echo $e->errorMessage();
			}catch (\Exception $e){
				echo $e->getMessage();
			}
			//----------------------------Termina PHPMailer----------------------------------------------------					
		}

		public function sendValidationEmail(){
			$subject = "Valida tu email!";
			$body = "Hola, ".$this->usuario.", gracias por registrarte. Para validar tu dirección de e-mail, por favor ingresá al siguiente enlace: http://urlejemplo/email_validado.php?codigo=".$this->codigo.". Muchas gracias!";
			$this->sendEmail($subject,$body);
		}

		public function sendRecoveryEmail(){
			$subject = "Restablecer contraseña";
			$body = "Hola! Hacé click en el siguiente enlace para restablecer tu contraseña: http://urlejemplo/reset_pass.php?codigo=".$this->codigo.". Seguí los pasos que se te indiquen para configurar una nueva. Muchas gracias!";
			$this->sendEmail($subject,$body);
		}		
	}
?>