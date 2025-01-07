<?php

class SignUpService
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new PDO("mysql:host=localhost;dbname=ioescribo", "root", "");
    }

    public function signUp($nombre, $correo, $pssword)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("SELECT * FROM usuario WHERE email = :correo");
        $sentencia->execute(array(':correo' => $correo));
        $unique_query = $sentencia->fetch(PDO::FETCH_ASSOC);
        if (!empty($unique_query)) {
            echo '<p> El correo ya está registrado </p>';
        } else {
            $sentencia2 = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $sentencia2 = $this->conexion->prepare("INSERT INTO usuario (nombre, email, pssword) 
            VALUES (:nombre, :correo, MD5(:pssword))");

            $sentencia2->execute(array(':nombre' => $nombre, ':correo' => $correo, ':pssword' => $pssword));
            header("location:login.php");
        }
    }
}