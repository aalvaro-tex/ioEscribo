<?php 

class UserService{

    private $conexion;
    public function __construct()
    {
        $this->conexion = new ConexionBD();
    }

    public function getUserByLogin($login){
        $query = $this->conexion->query("SELECT email, nombre, MD5(pssword) FROM usuario WHERE email='$login'");
        if (!$query) {
            throw new Exception("Error en la petición a base de datos.");
        }
        return $query->fetch_object();
    }

    public function deleteAccount($login){
        $query = $this->conexion->query("DELETE FROM usuario WHERE email='$login'");

        if (!$query) {
            throw new Exception("Error en la petición a base de datos.");
        }
    }
    

}