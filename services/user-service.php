<?php

class UserService
{

    private $conexion;
    public function __construct()
    {
        $this->conexion = new PDO("mysql:host=localhost;dbname=ioescribo", "root", "");
    }

    public function getUserByLogin($login)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("SELECT email, nombre, MD5(pssword) FROM usuario WHERE email = :login");
        $sentencia->execute(array(':login' => $login));
        $result = $sentencia->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            throw new Exception("Error en la petición a base de datos.");
        }
        return $result;
    }

    public function deleteAccount($login)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("DELETE FROM usuario WHERE email = :login");
        $sentencia->execute(array(':login' => $login));
        echo "Cuenta eliminada";
        unset($_SESSION["nombre"]);
        unset($_SESSION["correo"]);
        session_destroy();
    }


}