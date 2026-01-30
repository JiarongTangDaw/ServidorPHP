<?php
class Alumno
{
    public string $nombre;
    public string $apellidos;
    public string $sexo;
    public bool $es_profe_sexy;

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }
    public function getSexo(): string
    {
        return $this->sexo;
    }
    public function setEsProfeSexy($es_profe_sexy)
    {
        $this->es_profe_sexy = $es_profe_sexy;
    }
    public function getEsProfeSexy(): bool
    {
        return $this->es_profe_sexy;
    }
}
