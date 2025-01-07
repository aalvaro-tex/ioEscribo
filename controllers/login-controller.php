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
        if (empty($_POST["correo"]) || empty($_POST["pssword"])) {
            echo '<p style="margin:0px; color:red"> Rellena todos los campos </p>';
        } else {
            $correo = $_POST["correo"];
            $pssword = $_POST["pssword"];
            print_r($correo);
            print_r($pssword);
            print_r($this->loginService->login($correo, $pssword));
            if ($this->loginService->login($correo, $pssword)) {
                echo "entro";
                header("Location:my-documents.php");
            } else {
                echo '<p style="margin:0px; color:red"> Usuario o contraseña incorrectos </p>';
            }
        }
    }
}

if (!empty($_POST["btn-login"])) {
    $loginController = new LoginController();
    $checkedCorreo = htmlspecialchars($_POST["correo"]);
    $checkedPssword = htmlspecialchars($_POST["pssword"]);
    $loginController->login($checkedCorreo, $checkedPssword);
}
