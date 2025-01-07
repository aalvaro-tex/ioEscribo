<?php
include("my-notifications-service.php");
unset($conexion);
class LoginService
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = new PDO("mysql:host=localhost;dbname=ioescribo", "root", "");
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function login($correo, $pssword)
    {
        print_r($correo);
        print_r($pssword);
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("SELECT * FROM usuario WHERE email = :correo AND pssword = MD5(:pssword)");
        $sentencia->execute(array(':correo' => $correo, ':pssword' => $pssword));
        if (!$sentencia->execute(array(':correo' => $correo, ':pssword' => $pssword))) {
            print_r("Excepcion");
            throw new Exception("Error en la petición a base de datos.");
        } else {
            $datos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            if ($datos) {
                $_SESSION['nombre'] = $datos[0]['nombre'];
                $_SESSION['correo'] = $datos[0]['email'];
                return true;
            } else {
                return false;
            }

        }
    }
}