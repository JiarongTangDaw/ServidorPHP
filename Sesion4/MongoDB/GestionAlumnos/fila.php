<?php
class Fila
{
    public int $numero;
    public array $alumnos = [];

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getAlumnos()
    {
        return $this->alumnos;
    }

    public function setAlumnos($alumnos)
    {
        $this->alumnos = $alumnos;
    }
}

?>