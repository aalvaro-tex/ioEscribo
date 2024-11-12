<?php 


include("controllers/conexion_bd.php");
include("services/user-service.php");

class UserController{

    private $userService;
    private $user;

    public function __construct(){
        $this->userService = new UserService();
    }

    public function getUserByLogin(){
        return $this->userService->getUserByLogin($_SESSION["correo"]);
    }

    public function deleteAccount($login){
        $this->userService->deleteAccount($login);
        header("location: logout.php");
    }
}

if(isset($_POST["delete-account"])){
    $userController = new UserController();
    $userController->deleteAccount($_POST["login"]);
}