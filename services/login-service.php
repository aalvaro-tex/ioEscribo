<?php
include("my-notifications-service.php");
unset($conexion);
class LoginService
{

    private $conexion;
    private $myNotificationsService;

    public function __construct()
    {
        $this->conexion = new ConexionBD();
        $this->myNotificationsService = new MyNotificationsService();
    }

    public function login($correo, $pssword)
    {
        $query = $this->conexion->query("SELECT * FROM usuario WHERE email='$correo' AND pssword= MD5('$pssword')");
        if (!$query) {
            throw new Exception("Error en la petición a base de datos.");
        }
        if ($datos = $query->fetch_object()) {
            $_SESSION['nombre'] = $datos->nombre;
            $_SESSION['correo'] = $datos->email;
            $count_query = "SELECT COUNT(*) AS count FROM solicitud 
                WHERE autor='$datos->email' AND estado='PENDIENTE'";
            $result = $this->conexion->query($count_query);
            print_r($result->fetch_object());
            $_SESSION['solicitudes'] = $result->fetch_object();
            return true;
        } else {
            return false;
        }
    }
}