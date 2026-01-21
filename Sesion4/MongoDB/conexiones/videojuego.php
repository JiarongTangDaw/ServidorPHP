<?php
class Videojuego
{
    public int $video_juego_id;
    public int $plataforma_id;
    public string $titulo;
    public int $anio;
    public string $imagen;
    public string $metacritic;

    public function getvideo_juego_id()
    {
        return $this->video_juego_id;
    }

    public function setvideo_juego_id($video_juego_id)
    {
        $this->video_juego_id = $video_juego_id;
    }

    public function getplataforma_id()
    {
        return $this->plataforma_id;
    }

    public function setplataforma_id($plataforma_id)
    {
        $this->plataforma_id = $plataforma_id;
    }

    public function gettitulo()
    {
        return $this->titulo;
    }

    public function settitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function getanio()
    {
        return $this->anio;
    }

    public function setanio($anio)
    {
        $this->anio = $anio;
    }

    public function getimagen()
    {
        return $this->imagen;
    }

    public function setimagen($imagen)
    {
        $this->imagen = $imagen;
    }

    public function getmetacritic()
    {
        return $this->metacritic;
    }

    public function setmetacritic($metacritic)
    {
        $this->metacritic = $metacritic;
    }
    public function __toString() {
        return "ID:". $this->video_juego_id . ", <br> Título: " . $this->titulo . ",<br> Año: " . $this->anio . ",<br> Metacritic: " . $this->metacritic . ",<br> Imagen: " . $this->imagen."<br>";
    }
}
