<?php

class ExploreService
{

    private $conexion;
    public function __construct()
    {
        $this->conexion = new PDO("mysql:host=localhost;dbname=ioescribo", "root", "");
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllCategories()
    {

        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sentencia = $this->conexion->prepare("SELECT * FROM categoria");
        $sentencia->execute();

        $categorias = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        return $categorias;

    }

    public function getArticleById($id)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sentencia = $this->conexion->prepare("SELECT * FROM articulo WHERE id = :id");
        $sentencia->execute(array(':id' => $id));
        $articulo = $sentencia->fetch(\PDO::FETCH_ASSOC);
        return $articulo;
    }

    public function getCategoryName($id)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sentencia = $this->conexion->prepare("SELECT nombre FROM categoria WHERE id = :id");

        $sentencia->execute(array(':id' => $id));

        $categoria = $sentencia->fetch(\PDO::FETCH_ASSOC);

        return $categoria;
    }

    public function search($titulo, $id_categoria): array
    {
        if ($id_categoria === null || $id_categoria === "") {
            if ($titulo === null || $titulo === "") {
                $sentencia3 = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sentencia3 = $this->conexion->prepare(
                    "SELECT a.*, uar.id_rol FROM articulo AS a JOIN usuario_articulo_rol AS uar
                    ON a.id = uar.id_articulo JOIN usuario AS u
                            ON uar.login = u.email GROUP BY a.titulo"
                );
                $sentencia3->execute();
                $articulos = $sentencia3->fetchAll(\PDO::FETCH_ASSOC);
                return $articulos;
            } else {
                $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sentencia = $this->conexion->prepare(
                    "SELECT a.*, uar.id_rol FROM articulo AS a
                    JOIN usuario_articulo_rol AS uar
                    ON a.id = uar.id_articulo
                    JOIN usuario AS u
                    ON uar.login = u.email
                    WHERE a.titulo LIKE :titulo
                    GROUP BY a.titulo"
                );
                $sentencia->execute(array(':titulo' => $titulo));
                $articulos = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                return $articulos;
            }
        } else {
            if ($titulo === null || $titulo === "") {
                $sentencia2 = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sentencia2 = $this->conexion->prepare(
                    "SELECT a.*, uar.id_rol FROM articulo AS a
        JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        JOIN usuario AS u
        ON uar.login = u.email
        WHERE a.id_categoria = :id_categoria
        GROUP BY a.titulo"
                );
                $sentencia2->execute(array(':id_categoria' => $id_categoria));
                $articulos = $sentencia2->fetchAll(\PDO::FETCH_ASSOC);
                return $articulos;
            } else {
                $sentencia4 = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sentencia4 = $this->conexion->prepare(
                    "SELECT a.*, uar.id_rol FROM articulo AS a
        JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        JOIN usuario AS u
        ON uar.login = u.email
        WHERE a.titulo LIKE :titulo
        AND a.id_categoria = :id_categoria
        GROUP BY a.titulo"
                );
                $sentencia4->execute(array(':titulo' => $titulo, ':id_categoria' => $id_categoria));
                $articulos = $sentencia4->fetchAll(\PDO::FETCH_ASSOC);
                return $articulos;
            }
        }


    }

    public function getRol($id_documento, $login)
    {

        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sentencia = $this->conexion->prepare(
            "SELECT id_rol FROM usuario_articulo_rol 
        WHERE id_articulo = :id_documento AND login = :login"
        );

        $sentencia->execute(array(':id_documento' => $id_documento, ':login' => $login));

        return $sentencia->fetchAll();
    }

    public function sendEditRequest($autor, $solicitante, $id_articulo)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sentencia = $this->conexion->prepare("INSERT INTO solicitud (autor, solicitante, id_articulo) VALUES (:autor, :solicitante, :id_articulo)");
        $sentencia->execute(array(':autor' => $autor, ':solicitante' => $solicitante, ':id_articulo' => $id_articulo));
    }


}