<?php

	require_once("./error.php");

	class Marca
	{
		// Propiedades
		private $marca_id;
		private $marca;

		// Constructor
		public function __construct($data = [])
		{
			if (!empty($data)) {
				$this->marca_id = $data['marca_id'] ?? null;
				$this->marca    = $data['marca'] ?? null;
			}
		}

		// ====== Getters y Setters ======

		public function getId()
		{
			return $this->marca_id ?? 0;
		}

		public function getMarca()
		{
			return $this->marca ?? '';
		}

		public function setMarca($marca)
		{
			$this->marca = $marca;
		}

		// ====== CRUD ======

		public function guardar($pdo)
		{
			if ($this->marca_id === null || $this->marca_id === 0) {
				// INSERT
				$stmt = $pdo->prepare("
					INSERT INTO marcas (marca) 
					VALUES (:marca)
				");

				$stmt->execute([
					':marca' => $this->marca
				]);

				$this->marca_id = $pdo->lastInsertId();

			} else {
				// UPDATE
				$stmt = $pdo->prepare("
					UPDATE marcas 
					SET marca = :marca
					WHERE marca_id = :id
				");

				$stmt->execute([
					':marca' => $this->marca,
					':id'    => $this->marca_id
				]);
			}
		}

		// Obtener por ID
		public static function obtenerPorId($pdo, $id)
		{
			$stmt = $pdo->prepare("SELECT * FROM marcas WHERE marca_id = :id");
			$stmt->execute([':id' => $id]);

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data ? new self($data) : new Marca();
		}

		// Obtener todas
		public static function obtenerTodos($pdo)
		{
			$stmt = $pdo->query("SELECT * FROM marcas");
			$marcas = [];

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$marcas[] = new self($row);
			}

			return $marcas;
		}

		// Eliminar
		public function eliminar($pdo)
		{
			if ($this->marca_id != null) {
				$stmt = $pdo->prepare("DELETE FROM marcas WHERE marca_id = :id");
				$stmt->execute([':id' => $this->marca_id]);
			}
		}
	}
?>