<?php

require_once("./error.php");

class Modelo
{
    // Propiedades
    private $modelo_id;
    private $modelo;
    private $marca_id;

    // Constructor
    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->modelo_id = $data['modelo_id'] ?? null;
            $this->modelo    = $data['modelo'] ?? null;
            $this->marca_id  = $data['marca_id'] ?? null;
        }
    }

    // ====== Getters y Setters ======

    public function getId()
    {
        return $this->modelo_id ?? 0;
    }

    public function getModelo()
    {
        return $this->modelo ?? '';
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    public function getMarcaId()
    {
        return $this->marca_id ?? 0;
    }

    public function setMarcaId($marca_id)
    {
        $this->marca_id = $marca_id;
    }

    // ====== CRUD ======

    public function guardar($pdo)
    {
        if ($this->modelo_id === null || $this->modelo_id === 0) {
            // INSERT
            $stmt = $pdo->prepare("
                INSERT INTO modelos (modelo, marca_id) 
                VALUES (:modelo, :marca_id)
            ");

            $stmt->execute([
                ':modelo'   => $this->modelo,
                ':marca_id' => $this->marca_id
            ]);

            $this->modelo_id = $pdo->lastInsertId();

        } else {
            // UPDATE
            $stmt = $pdo->prepare("
                UPDATE modelos 
                SET modelo = :modelo,
                    marca_id = :marca_id
                WHERE modelo_id = :id
            ");

            $stmt->execute([
                ':modelo'   => $this->modelo,
                ':marca_id' => $this->marca_id,
                ':id'       => $this->modelo_id
            ]);
        }
    }

    // Obtener por ID
    public static function obtenerPorId($pdo, $id)
    {
        $stmt = $pdo->prepare("SELECT * FROM modelos WHERE modelo_id = :id");
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new self($data) : new Modelo();
    }

    // Obtener todos
    public static function obtenerTodos($pdo)
    {
        $stmt = $pdo->query("SELECT * FROM modelos");
        $modelos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $modelos[] = new self($row);
        }

        return $modelos;
    }

    // Eliminar
    public function eliminar($pdo)
    {
        if ($this->modelo_id != null) {
            $stmt = $pdo->prepare("DELETE FROM modelos WHERE modelo_id = :id");
            $stmt->execute([':id' => $this->modelo_id]);
        }
    }
}
?>