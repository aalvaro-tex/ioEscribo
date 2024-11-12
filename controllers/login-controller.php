<?php
include("controllers/conexion_bd.php");
include("services/login-service.php");

class LoginController
{

    private $loginService;

    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    public function login($correo, $pssword)
    {
        if ($_POST["correo"] == "" || $_POST["pssword"] == "") {
            echo '<p style="margin:0px; color:red"> Rellena todos los campos </p>';
        } else {
            $correo = $_POST["correo"];
            $pssword = $_POST["pssword"];
            if ($this->loginService->login($correo, $pssword)) {
                header("location:index.php");
            } else {
                echo '<p style="margin:0px; color:red"> Usuario o contraseña incorrectos </p>';
            }
        }
    }
}

if (!empty($_POST["btn-login"])) {
    $loginController = new LoginController();
    $loginController->login($_POST["correo"], $_POST["pssword"]);
}
