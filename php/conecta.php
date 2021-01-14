<?php
	class Conecta{
		private static $conn = null;
		private function __construct(){}

		public static function conectar(){
			require_once 'pdoconfig.php';
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			self::$conn=new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
			return self::$conn;
		}
	}
?>