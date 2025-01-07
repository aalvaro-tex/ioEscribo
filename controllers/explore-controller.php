<?php
include("controllers/conexion_bd.php");
include("services/explore-service.php");

class ExploreController
{

    private $exploreService;
    private $login;

    public function __construct()
    {
        $this->exploreService = new ExploreService();
        $this->login = $_SESSION["correo"];

    }

    public function getAllCategories()
    {
        $result = $this->exploreService->getAllCategories();
        return $result;
    }

    public function getArticleById($id)
    {
        return $this->exploreService->getArticleById($id);
    }

    public function getCategoryName($id)
    {
        return $this->exploreService->getCategoryName($id);
    }

    public function search($titulo = null, $id_categoria = null)
    {
        return $this->exploreService->search($titulo, $id_categoria);
    }

    public function getRol($id_documento)
    {
        return $this->exploreService->getRol($id_documento, $this->login);
    }

    public function sendEditRequest($autor, $solicitante, $id_articulo)
    {
        return $this->exploreService->sendEditRequest($autor, $solicitante, $id_articulo);
    }
}

if (!empty($_POST["search-articles"])) {
    $exploreController = new ExploreController();
    print_r($_POST);
    if (empty($_POST["titulo"]) && empty($_POST["id_categoria"])) {
        print_r("Centro");
        $searchResult = $exploreController->search(null, null);
        return $searchResult;
    } else if (empty($_POST["titulo"]) && !empty($_POST["id_categoria"])) {
        print_r("Centro2");
        $searchResult = $exploreController->search(null, $_POST["id_categoria"]);
        return $searchResult;
    } else if (empty($_POST["id_categoria"]) && !empty($_POST["titulo"])) {
        print_r("Centro3");
        $searchResult = $exploreController->search($_POST["titulo"], null);
        return $searchResult;
    } else {
        print_r("Centro4");
        $searchResult = $exploreController->search($_POST["titulo"], $_POST["id_categoria"]);
        return $searchResult;
    }
}

if (!empty($_POST["request-edit"])) {
    $exploreController = new ExploreController();
    $checkedAutor = htmlspecialchars($_POST["autor"]);
    $checkedSolicitante = htmlspecialchars($_POST["solicitante"]);
    $exploreController->sendEditRequest($checkedAutor, $checkedSolicitante, $_POST["id_articulo"]);
}