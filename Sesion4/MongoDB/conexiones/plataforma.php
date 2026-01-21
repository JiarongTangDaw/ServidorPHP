<?php
class Plataforma
{
    public int $plataforma_id;
    public string $plataforma;
    public array $videojuegos = [];

    public function getplataforma_id()
    {
        return $this->plataforma_id;
    }

    public function setplataforma_id($plataforma_id)
    {
        $this->plataforma_id = $plataforma_id;
    }

    public function getplataforma()
    {
        return $this->plataforma;
    }

    public function setplataforma($plataforma)
    {
        $this->plataforma = $plataforma;
    }

    public function setvideojuegos($videojuegos)
    {
        $this->videojuegos = $videojuegos;
    }
    public function getvideojuegos(): array
    {
        return $this->videojuegos;
    }
    public function __toString() {
        return "ID:". $this->plataforma_id . ", <br> Plataforma: " . $this->plataforma . ",<br> Videojuegos: " . $this->videojuegos . "<br>";
    }
}
