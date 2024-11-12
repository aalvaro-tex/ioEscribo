<?php
class ConexionBD
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = mysqli_connect("localhost", "root", "", "ioescribo", "3306");
        $this->conexion->set_charset("utf8mb4");
    }
    public function query($sql)
    {
        return mysqli_query($this->conexion, $sql);
    }
}
