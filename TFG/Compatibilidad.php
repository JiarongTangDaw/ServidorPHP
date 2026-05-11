<?php

require_once("./error.php");

class Compatibilidad
{
    private $compatibilidad_id;
    private $modelo1_id;
    private $modelo2_id;
    private $tipoaccesorio_id;

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->compatibilidad_id = $data['compatibilidad_id'] ?? null;
            $this->modelo1_id        = $data['modelo1_id'] ?? null;
            $this->modelo2_id        = $data['modelo2_id'] ?? null;
            $this->tipoaccesorio_id  = $data['tipoaccesorio_id'] ?? null;
        }
    }

    // ====== GETTERS / SETTERS ======

    public function getId()
    {
        return $this->compatibilidad_id ?? 0;
    }

    public function getModelo1Id()
    {
        return $this->modelo1_id ?? 0;
    }

    public function setModelo1Id($id)
    {
        $this->modelo1_id = $id;
    }

    public function getModelo2Id()
    {
        return $this->modelo2_id ?? 0;
    }

    public function setModelo2Id($id)
    {
        $this->modelo2_id = $id;
    }

    public function getTipoAccesorioId()
    {
        return $this->tipoaccesorio_id ?? 0;
    }

    public function setTipoAccesorioId($id)
    {
        $this->tipoaccesorio_id = $id;
    }

    // ====== INSERTAR (doble dirección) ======

    public function guardar($pdo)
    {
         $pdo->beginTransaction();

        // Inserción A -> B
        $stmt1 = $pdo->prepare("
            INSERT INTO compatibilidades (modelo1_id, modelo2_id, tipoaccesorio_id)
            VALUES (:m1, :m2, :tipo)
        ");

        $stmt1->execute([
            ':m1'   => $this->modelo1_id,
            ':m2'   => $this->modelo2_id,
            ':tipo' => $this->tipoaccesorio_id
        ]);

        // Inserción B -> A
        $stmt2 = $pdo->prepare("
            INSERT INTO compatibilidades (modelo1_id, modelo2_id, tipoaccesorio_id)
            VALUES (:m1, :m2, :tipo)
        ");

        $stmt2->execute([
            ':m1'   => $this->modelo2_id,
            ':m2'   => $this->modelo1_id,
            ':tipo' => $this->tipoaccesorio_id
        ]);

        $pdo->commit();
    }

    // ====== ELIMINAR (doble dirección) ======

    public function eliminar($pdo)
    {
        $pdo->beginTransaction();

        // Eliminar A -> B
        $stmt1 = $pdo->prepare("
            DELETE FROM compatibilidades
            WHERE modelo1_id = :m1 AND modelo2_id = :m2 AND tipoaccesorio_id = :tipo
        ");

        $stmt1->execute([
            ':m1'   => $this->modelo1_id,
            ':m2'   => $this->modelo2_id,
            ':tipo' => $this->tipoaccesorio_id
        ]);

        // Eliminar B -> A
        $stmt2 = $pdo->prepare("
            DELETE FROM compatibilidades
            WHERE modelo1_id = :m1 AND modelo2_id = :m2 AND tipoaccesorio_id = :tipo
        ");

        $stmt2->execute([
            ':m1'   => $this->modelo2_id,
            ':m2'   => $this->modelo1_id,
            ':tipo' => $this->tipoaccesorio_id
        ]);

        $pdo->commit();
    }

    // ====== OBTENER TODAS ======

    public static function obtenerTodos($pdo)
    {
        $stmt = $pdo->query("SELECT * FROM compatibilidades");
        $lista = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $lista[] = new self($row);
        }

        return $lista;
    }

    // ====== OBTENER POR ID ======

    public static function obtenerPorId($pdo, $id)
    {
        $stmt = $pdo->prepare("SELECT * FROM compatibilidades WHERE compatibilidad_id = :id");
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new self($data) : new Compatibilidad();
    }
}
?>