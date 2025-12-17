<?php
    class Videojuego {
        
        private $consola;
        private $titulo;
        private $anio;
        private $metacritic;
        private $portada;

        public function __construct($data = []){
            $this->consola = $data[0];
            $this->titulo = $data[1];
            $this->anio = $data[2];
            if(is_numeric($data[3])){
                $this->metacritic = $data[3];
            }else{
                $this->metacritic = 0;
            }
            $this->portada = $data[4];
        }

        public function getConsola(){
            return $this->consola;
        }

        public function getTitulo(){
            return $this->titulo;
        }

        public function getAnio() {
            return $this->anio;
        }

        public function getMetacritic() {
            return $this->metacritic;
        }

        public function getPortada() {
            return $this->portada;
        }

        public function imprimir() {
            return "Consola: " . $this->consola . " Titulo: " . $this->titulo . " Año: " . $this->anio . " Metacritic: " . $this->metacritic . " Portada: " . $this->portada;
        }
    }
    
?>