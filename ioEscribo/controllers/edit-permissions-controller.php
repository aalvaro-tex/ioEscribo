<?php 
include("controllers/conexion_bd.php");
include("services/edit-permissions-service.php");


class EditPermissionsController{

    
    private $editPermissionsService;
    private $login;
    public $id_articulo;

    public function __construct(){
        $this->editPermissionsService = new EditPermissionsService($_GET["id_articulo"]);
        $this->login = $_SESSION["correo"];
        $this->id_articulo = $_GET["id_articulo"];
    }

    public function getArticuloById($id_articulo){
        return $this->editPermissionsService->getArticuloById($id_articulo);
    }

    public function getCollaborators($id_articulo){
        return $this->editPermissionsService->getCollaborators($id_articulo);
    }

    public function addCollab($login){
        $this->editPermissionsService->addCollab($login, $this->id_articulo);
    }

    public function removeCollab($login){
        $this->editPermissionsService->removeCollab($login, $this->id_articulo);
    }


}

if(isset($_POST["add-collab"])){
    $editPermissionsController = new EditPermissionsController();
    $editPermissionsController->addCollab($_POST["login-collab"]);
}

if(isset($_POST["delete-collab"])){
    $editPermissionsController = new EditPermissionsController();
    $editPermissionsController->removeCollab($_POST["login-collab"]);
}