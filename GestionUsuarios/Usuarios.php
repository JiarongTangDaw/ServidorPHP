<?php

// Incluyo el control de errores para gestión de excepciones
require_once("./error.php");

/**
 * Clase Usuario
 * Modelo que representa la tabla 'usuarios' de la base de datos.
 * Maneja las operaciones CRUD y la autenticación.
 */
class Usuario
{
    // Propiedades privadas que mapean las columnas de la BD
    private $usuario_id;
    private $usuario;
    private $email;
    private $nombre;
    private $password;
    private $apellidos;
    private $rol_id;

    // Constructor: Inicializa el objeto, permitiendo pasar un array asociativo (útil para PDO::FETCH_ASSOC)
    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->usuario_id = $data['usuario_id'] ?? null;
            $this->usuario    = $data['usuario'] ?? null;
            $this->password   = $data['password'] ?? null;
            $this->email      = $data['email'] ?? null;
            $this->nombre     = $data['nombre'] ?? null;
            $this->apellidos  = $data['apellidos'] ?? null;
            $this->rol_id     = $data['rol_id'] ?? null;
        }
    }

    // ====== Getters y Setters ======
    // Permiten acceder y modificar las propiedades privadas de forma controlada

    public function getId()
    {
        return $this->usuario_id ?? 0;
    }

    public function getUsuario()
    {
        return ($this->usuario ?? '');
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

    public function getEmail()
    {
        return $this->email ?? '';
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getNombre()
    {
        return $this->nombre ?? '';
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos ?? '';
    }
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function getRolId()
    {
        return $this->rol_id ?? 0;
    }
    public function setRolId($rol_id)
    {
        $this->rol_id = $rol_id;
    }


    // ====== Métodos CRUD con PDO ======

    /**
     * Guarda el usuario en la base de datos.
     * Detecta automáticamente si es una inserción (nuevo usuario) o una actualización (editar rol)
     * basándose en si existe 'usuario_id'.
     */
    public function guardar($pdo)
    {
        global $config;
        // Se obtiene la sal/clave extra del archivo de configuración para mayor seguridad
        $claveEC = $config["pass"]["hash"];

        if ($this->usuario_id === null || $this->usuario_id === 0) {
            // === INSERTAR NUEVO USUARIO ===
            $stmt = $pdo->prepare("INSERT INTO usuarios (usuario,password, email, nombre, apellidos, rol_id) 
                                   VALUES (:usuario,:password, :email, :nombre, :apellidos, :rol_id)");

            // Se ejecuta la consulta encriptando la contraseña con BCRYPT (PASSWORD_DEFAULT)
            $stmt->execute([
                ':usuario'   => $this->usuario,
                ':password'  => password_hash($this->password. $claveEC, PASSWORD_DEFAULT),
                ':email'     => $this->email,
                ':nombre'    => $this->nombre,
                ':apellidos' => $this->apellidos,
                ':rol_id'    => $this->rol_id,
            ]);

            // Recuperamos el ID generado por la BD
            $this->usuario_id = $pdo->lastInsertId();
        } else {
            // === ACTUALIZAR USUARIO EXISTENTE ===
            // Nota: En este sistema parece que solo se permite actualizar el Rol desde aquí
            $stmt = $pdo->prepare("UPDATE usuarios SET 
                                    rol_id = :rol_id
                                   WHERE usuario_id = :id");

            $stmt->execute([
                ':rol_id'    => $this->rol_id,
                ':id'        => $this->usuario_id
            ]);
        }
    }

    // Busca un usuario por su ID y devuelve un objeto Usuario
    public static function obtenerPorId($pdo, $id)
    {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario_id = :id");
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new self($data) : new Usuario();
    }

    /**
     * Verifica las credenciales para iniciar sesión.
     * Retorna el objeto Usuario si es correcto, o null si falla.
     */
    public static function login($pdo, $usuario, $password)
    {
        global $config;
        $claveEC = $config["pass"]["hash"];

        // 1. Buscamos al usuario por nombre de usuario
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->execute([':usuario' => $usuario]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            // Usuario no encontrado
            return null;
        }

        // 2. Obtenemos el hash almacenado en la BD
        $hashGuardado = $data["password"];

        // 3. Verificamos la contraseña ingresada (concatenada con la clave de config) contra el hash
        if (!password_verify($password . $claveEC, $hashGuardado)) {
            // Contraseña incorrecta
            return null;
        }

        // Login exitoso: devolvemos el objeto
        return new self($data);
    }

    // Obtiene todos los usuarios para listados
    public static function obtenerTodos($pdo)
    {
        $stmt = $pdo->query("SELECT * FROM usuarios");
        $usuarios = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $usuarios[] = new self($row);
        }

        return $usuarios;
    }

    // Elimina el usuario actual de la base de datos
    public function eliminar($pdo)
    {
        if ($this->usuario_id != null) {
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE usuario_id = :id");
            $stmt->execute([':id' => $this->usuario_id]);
        }
    }
}