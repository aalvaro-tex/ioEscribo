<?php
include("conexion_bd.php");
include("services/sign-up-service.php");

class SignUpController{
        
            private $signUpService;
        
            public function __construct()
            {
                $this->signUpService = new SignUpService();
            }
        
            public function signUp($nombre, $correo, $pssword)
            {
                if ($correo == "" || $pssword == "" || $nombre == "") {
                    echo '<p style="margin:0px; color:red"> Rellena todos los campos </p>';
                } else {
                    if ($this->signUpService->signUp($nombre, $correo, $pssword)) {
                        header("location:login.php");
                    } else {
                    }
                }
            }
}

if(!empty($_POST["btn-sign-up"])){
    $signUpController = new SignUpController();
    $signUpController->signUp($_POST["nombre"], $_POST["correo"], $_POST["pssword"]);
}