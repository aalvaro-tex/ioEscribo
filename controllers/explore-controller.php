<?php 
include("controllers/conexion_bd.php");
include("services/explore-service.php");

class ExploreController{
    
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

        public function search($titulo, $id_categoria){
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
    $searchResult = $exploreController->search($_POST["titulo"], $_POST["id_categoria"]);
    return $searchResult;
}

if (!empty($_POST["request-edit"])) {
    $exploreController = new ExploreController();
    $exploreController->sendEditRequest($_POST["autor"], $_POST["solicitante"], $_POST["id_articulo"]);
    echo "Llego";
}