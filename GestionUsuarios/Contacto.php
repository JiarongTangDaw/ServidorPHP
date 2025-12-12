<?php

//Incluyo el control de errores
require_once("./error.php");

//Siempre esta bien modelar las clases
//Modelado de clase de usuario
class Contacto
{
    private $contacto_id;
    private $nombre;
    private $apellidos;
    private $email;
    private $telefono;

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->cliente_id = $data['contacto_id'] ?? null;
            $this->nombre     = $data['nombre'] ?? null;
            $this->email      = $data['email'] ?? null;
            $this->telefono   = $data['telefono'] ?? null;
            $this->apellidos  = $data['apellidos'] ?? null;
        }
    }

    // ====== Getters y Setters ======

    public function getId()
    {
        return $this->contacto_id ?? 0;
    }

    public function getNombre()
    {
        return $this->nombre ?? '';
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getEmail()
    {
        return $this->email ?? '';
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getTelefono()
    {
        return $this->telefono ?? '';
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getApellidos()
    {
        return $this->apellidos ?? '';
    }
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    // ====== Métodos CRUD con PDO ======

    public function guardar($pdo)
    {
        if ($this->contacto_id === null || $this->contacto_id === 0) {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO contactos (nombre, email, telefono, apellidos) 
                                   VALUES (:nombre,:email, :telefono, :apellidos )");

            $stmt->execute([
                ':nombre'   => $this->nombre,
                ':email'     => $this->email,
                ':telefono'    => $this->telefono,
                ':apellidos' => $this->apellidos,
            ]);

            $this->contacto_id = $pdo->lastInsertId();
        } else {
            // Update
            $stmt = $pdo->prepare("UPDATE contactos SET 
                                    nombre = :nombre,
                                    email = :email,
                                    telefono = :telefono,
                                    apellidos = :apellidos,
                                   WHERE contacto_id = :id");

            $stmt->execute([
                ':nombre'   => $this->nombre,
                ':email'     => $this->email,
                ':telefono'    => $this->telefono,
                ':apellidos' => $this->apellidos,
                ':id'        => $this->contacto_id
            ]);
        }
    }

    public static function obtenerPorId($pdo, $id)
    {
        $stmt = $pdo->prepare("SELECT * FROM contactos WHERE contacto_id = :id");
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new self($data) : new Cliente();
    }

  
    public static function obtenerTodos($pdo)
    {
        $stmt = $pdo->query("SELECT * FROM contactos");
        $contactos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cotactos[] = new self($row);
        }

        return $contactos;
    }

    public function eliminar($pdo)
    {
        if ($this->contacto_id != null) {
            $stmt = $pdo->prepare("DELETE FROM contactos WHERE contacto_id = :id");
            $stmt->execute([':id' => $this->contacto_id]);
        }
    }
}
