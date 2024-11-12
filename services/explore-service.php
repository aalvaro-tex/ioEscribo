<?php

class ExploreService
{

    private $conexion;
    public function __construct()
    {
        $this->conexion = new ConexionBD();
    }

    public function getAllCategories()
    {
        $all_categories_query = "SELECT * FROM categoria";

        $result = $this->conexion->query($all_categories_query);
        if ($result === false) {
            // Handle error appropriately
            return [];
        }
        return $result;
    }

    public function getArticleById($id){
        $article_query = "SELECT * FROM articulo WHERE id = '$id'";
        $result = $this->conexion->query($article_query);
        return $result;
    }

    public function search($titulo, $id_categoria)
    {
        if (!$id_categoria) {
            $search_query = "SELECT a.*, uar.id_rol FROM articulo AS a
        JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        JOIN usuario AS u
        ON uar.login = u.email
        WHERE a.titulo LIKE '%$titulo%'
        GROUP BY a.titulo";
        } else {
            $search_query = "SELECT a.*, uar.id_rol FROM articulo AS a
        JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        JOIN usuario AS u
        ON uar.login = u.email
        WHERE a.titulo LIKE '%$titulo%'
        AND a.id_categoria = '$id_categoria'
        GROUP BY a.titulo";
        }
        $result = $this->conexion->query($search_query);
        return $result;
    }

    public function getRol($id_documento, $login)
    {
        $rol_query = "SELECT id_rol FROM usuario_articulo_rol 
        WHERE id_articulo = '$id_documento' AND login = '$login'";

        $result = $this->conexion->query($rol_query);
        return mysqli_fetch_object($result);
    }

    public function sendEditRequest($autor, $solicitante, $id_articulo){
        $request_query = "INSERT INTO solicitud (autor, solicitante, id_articulo) 
        VALUES ('$autor', '$solicitante', '$id_articulo')";
        $result = $this->conexion->query($request_query);
        return $result;
    }


}