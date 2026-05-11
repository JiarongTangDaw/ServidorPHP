<?php

	require_once("./error.php");

	class Usuario
	{
		// Propiedades
		private $usuario_id;
		private $usuario;
		private $password;

		// Constructor
		public function __construct($data = [])
		{
			if (!empty($data)) {
				$this->usuario_id = $data['usuario_id'] ?? null;
				$this->usuario    = $data['usuario'] ?? null;
				$this->password   = $data['password'] ?? null;
			}
		}

		// ====== Getters y Setters ======

		public function getId()
		{
			return $this->usuario_id ?? 0;
		}

		public function getUsuario()
		{
			return $this->usuario ?? '';
		}

		public function setUsuario($usuario)
		{
			$this->usuario = $usuario;
		}

		public function getPassword()
		{
			return $this->password ?? '';
		}

		public function setPassword($password)
		{
			$this->password = $password;
		}

		// ====== CRUD ======

		public function guardar($pdo)
		{
			global $config;

			$claveEC = $config["pass"]["hash"];

			if ($this->usuario_id === null || $this->usuario_id === 0) {
				// INSERT
				$stmt = $pdo->prepare("
					INSERT INTO usuarios (usuario, password) 
					VALUES (:usuario, :password)
				");

				$stmt->execute([
					':usuario'  => $this->usuario,
					':password' => password_hash($this->password . $claveEC, PASSWORD_DEFAULT),
				]);

				$this->usuario_id = $pdo->lastInsertId();

			} else {
				// UPDATE
				$stmt = $pdo->prepare("
					UPDATE usuarios 
					SET usuario = :usuario,
						password = :password
					WHERE usuario_id = :id
				");

				$stmt->execute([
					':usuario'  => $this->usuario,
					':password' => password_hash($this->password . $claveEC, PASSWORD_DEFAULT),
					':id'       => $this->usuario_id
				]);
			}
		}

		// Obtener por ID
		public static function obtenerPorId($pdo, $id)
		{
			$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario_id = :id");
			$stmt->execute([':id' => $id]);

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data ? new self($data) : new Usuario();
		}

		// LOGIN
		public static function login($pdo, $usuario, $password)
		{
			global $config;
			$claveEC = $config["pass"]["hash"];

			$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
			$stmt->execute([':usuario' => $usuario]);

			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!$data) {
				return null;
			}

			$hashGuardado = $data["password"];

			if (!password_verify($password . $claveEC, $hashGuardado)) {
				return null;
			}

			return new self($data);
		}

		// Obtener todos
		public static function obtenerTodos($pdo)
		{
			$stmt = $pdo->query("SELECT * FROM usuarios");
			$usuarios = [];

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$usuarios[] = new self($row);
			}

			return $usuarios;
		}

		// Eliminar
		public function eliminar($pdo)
		{
			if ($this->usuario_id != null) {
				$stmt = $pdo->prepare("DELETE FROM usuarios WHERE usuario_id = :id");
				$stmt->execute([':id' => $this->usuario_id]);
			}
		}
	}
?>