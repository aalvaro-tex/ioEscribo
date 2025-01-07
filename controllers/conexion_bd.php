<?php
class ConexionBD extends PDO
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new PDO("mysql:host=localhost;dbname=ioescribo", "root", "");
    }
}
