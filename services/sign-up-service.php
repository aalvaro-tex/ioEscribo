<?php 

class SignUpService
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new ConexionBD();
    }

    public function signUp($nombre, $correo, $pssword)
    {
        $unique_query = $this->conexion->query("SELECT * FROM usuario WHERE email='$correo'");
        if( $unique_query->num_rows > 0) {
            echo '<p> El correo ya está registrado </p>';
        } else {
        $unique_query = $this->conexion->query(
            "INSERT INTO usuario (nombre, email, pssword) VALUES ('$nombre', '$correo', MD5('$pssword'))"
        );
        header("location:login.php");
    }
    }
}