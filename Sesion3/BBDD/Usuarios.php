<?php
    require_once './encriptador.php';
    require_once './error.php';

    class Usuarios {
        private $id;
        private $username;
        private $password;
        private $rol;

        public function __construct($_username, $_password, $_rol){
            $this -> username = $_username;
            $this -> password = $_password;
            $this -> rol = $_rol;
        }

        //gets y sets

        public function getUsername(){
            return $this -> username;
        }

        public function getPassword(){
            return $this -> password;
        }

        public function getRol(){
            return $this -> rol;
        }

        public function setUsername($newUsername){
            $this -> username = $newUsername;
        }

        public function setPassword($newPassword){
            $this -> password = $newPassword;
        }

        public function setRol($newRol){
            $this -> rol = $newRol;
        }

        // funcion estatico

        // funcion para verificar si existe un usuario con el mismo nombre
        public static function existeUsuario($username) {
            global $db;

            $stmt = $db -> prepare("SELECT COUNT(*) FROM Usuarios WHERE username = ?");
            $stmt -> execute([$username]);
            return $stmt -> fetchColumn() > 0;
        }

        //FUNCIONES CRUD

        public function addUsuario(){
            global $db;

            //insertar nuevo usuario
            $stmt = $db -> prepare("INSERT INTO Usuarios (username, password, rol) VALUES (?,?,?)");
            $pCifrado = cifrar($this -> getPassword());
            $idRol = ($this -> getRol() == 'admin')? 1 : 2;
            $stmt -> execute([$this -> getUsername(), $pCifrado, $idRol]);
        }

        public function getPusuario(){
            global $db;

            $stmt = $db -> prepare ("SELECT password FROM Usuarios WHERE username = ?");
            $stmt -> execute ([$this -> username]);
            $salida = $stmt->fetchColumn();

            return $salida;
        }

        public function updateUsuario($campo, $valor,$id){
            global $db;

            $stmt = $db -> prepare ("UPDATE Usuarios SET ? = ? WHERE id = ?");
            $stmt -> execute ([$campo, $valor, $this -> username]);
        }
    }
?>