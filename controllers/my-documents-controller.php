<?php
include("controllers/conexion_bd.php");
include("services/my-documents-service.php");

class MyDocumentsController
{

    private $myDocumentsService;
    private $login;

    public function __construct()
    {
        $this->myDocumentsService = new MyDocumentsService();
        $this->login = $_SESSION["correo"];

    }

    public function getAllDocuments()
    {
        return $this->myDocumentsService->getAllDocuments($this->login);
    }

    public function getAllDocumentsByRol($id_rol)
    {
        return $this->myDocumentsService->getAllDocumentsByRol($this->login, $id_rol);
    }

    public function getDocumentId($titulo, $login)
    {
        return $this->myDocumentsService->getDocumentId($titulo, $login);
    }

    public function getAllCategories()
    {
        return $this->myDocumentsService->getAllCategories();
    }

    public function getRol($id_documento)
    {
        return $this->myDocumentsService->getRol($id_documento, $this->login);
    }

    public function addArticle($titulo, $descripcion, $id_categoria, $contenido)
    {
        $this->myDocumentsService->addArticle($titulo, $descripcion, $id_categoria, $contenido, $this->login);
    }

    public function deleteArticle($id_articulo)
    {
        $this->myDocumentsService->deleteArticle($id_articulo);
    }

    public function updateArticle($id_articulo, $descripcion, $titulo, $id_categoria, $contenido)
    {
        $this->myDocumentsService->updateArticle($id_articulo, $descripcion, $titulo, $id_categoria, $contenido);
    }
}

if (!empty($_POST["add-document"])) {
    $myDocumentsController = new MyDocumentsController();
    $checkedTitulo = htmlspecialchars($_POST["titulo"]);
    $checkedDescripcion = htmlspecialchars($_POST["descripcion"]);
    $checkedContenido = htmlspecialchars($_POST["contenido"]);
    $myDocumentsController->addArticle($checkedTitulo, $checkedDescripcion, $_POST["id_categoria"], $checkedContenido);
}

if (!empty($_POST["delete-document"])) {
    $myDocumentsController = new MyDocumentsController();
    $myDocumentsController->deleteArticle($_POST["id_articulo"]);
}

if (!empty($_POST["update-document"])) {
    $myDocumentsController = new MyDocumentsController();
    $myDocumentsController->updateArticle($_POST["id_articulo"], $_POST["descripcion"], $_POST["titulo"], $_POST["id_categoria"], $_POST["contenido"]);
}