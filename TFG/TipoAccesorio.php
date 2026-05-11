<?php

require_once("./error.php");

class TipoAccesorio
{
    // Propiedades
    private $tipoAccesorio_id;
    private $tipoAccesorio;

    // Constructor
    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->tipoAccesorio_id = $data['tipoAccesorio_id'] ?? null;
            $this->tipoAccesorio    = $data['tipoAccesorio'] ?? null;
        }
    }

    // ====== Getters y Setters ======

    public function getId()
    {
        return $this->tipoAccesorio_id ?? 0;
    }

    public function getTipoAccesorio()
    {
        return $this->tipoAccesorio ?? '';
    }

    public function setTipoAccesorio($tipoAccesorio)
    {
        $this->tipoAccesorio = $tipoAccesorio;
    }

    // ====== CRUD ======

    public function guardar($pdo)
    {
        if ($this->tipoAccesorio_id === null || $this->tipoAccesorio_id === 0) {
            // INSERT
            $stmt = $pdo->prepare("
                INSERT INTO tipoAccesorios (tipoAccesorio) 
                VALUES (:tipoAccesorio)
            ");

            $stmt->execute([
                ':tipoAccesorio' => $this->tipoAccesorio
            ]);

            $this->tipoAccesorio_id = $pdo->lastInsertId();

        } else {
            // UPDATE
            $stmt = $pdo->prepare("
                UPDATE tipoAccesorios 
                SET tipoAccesorio = :tipoAccesorio
                WHERE tipoAccesorio_id = :id
            ");

            $stmt->execute([
                ':tipoAccesorio' => $this->tipoAccesorio,
                ':id'            => $this->tipoAccesorio_id
            ]);
        }
    }

    // Obtener por ID
    public static function obtenerPorId($pdo, $id)
    {
        $stmt = $pdo->prepare("SELECT * FROM tipoAccesorios WHERE tipoAccesorio_id = :id");
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new self($data) : new TipoAccesorio();
    }

    // Obtener todos
    public static function obtenerTodos($pdo)
    {
        $stmt = $pdo->query("SELECT * FROM tipoAccesorios");
        $tipos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tipos[] = new self($row);
        }

        return $tipos;
    }

    // Eliminar
    public function eliminar($pdo)
    {
        if ($this->tipoAccesorio_id != null) {
            $stmt = $pdo->prepare("DELETE FROM tipoAccesorios WHERE tipoAccesorio_id = :id");
            $stmt->execute([':id' => $this->tipoAccesorio_id]);
        }
    }
}