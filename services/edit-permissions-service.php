<?php

class EditPermissionsService
{

    private $conexion;
    private $id_articulo;
    public function __construct($id_articulo)
    {
        $this->conexion = new PDO("mysql:host=localhost;dbname=ioescribo", "root", "");
        $this->id_articulo = $id_articulo;
    }

    public function getCollaborators($id_articulo)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sentencia = $this->conexion->prepare(
            "SELECT u.* FROM USUARIO AS u
        JOIN usuario_articulo_rol AS uar
        ON u.email = uar.login
        JOIN rol AS r
        ON uar.id_rol = r.id
        WHERE uar.id_articulo = :id_articulo
        and r.nombre = 'COLABORADOR'"
        );
        $sentencia->execute(array(':id_articulo' => $id_articulo));
        $colaboradores = $sentencia->fetchAll();
        return $colaboradores;
    }

    public function getArticuloById($id_articulo)
    {

        $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sentencia = $this->conexion->prepare(
            "SELECT a.*, u.nombre AS Unombre FROM articulo AS a
        JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        JOIN usuario AS u 
        ON uar.login = u.email
        WHERE id = :id_articulo
        AND uar.id_rol = 1"
        );

        $sentencia->execute(array(':id_articulo' => $id_articulo));
        $articulo = $sentencia->fetch();

        return $articulo;
    }

    public function addCollab($login, $id_articulo)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sentencia = $this->conexion->prepare(
            "INSERT INTO usuario_articulo_rol (login, id_articulo, id_rol) 
        VALUES (:login, :id_articulo, 2)"
        );

        return $sentencia->execute(array(':login' => $login, ':id_articulo' => $id_articulo));
    }

    public function removeCollab($login, $id_articulo)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sentencia = $this->conexion->prepare(
            "DELETE FROM usuario_articulo_rol
            WHERE login = :login
            AND id_articulo = :id_articulo"
        );

        return $sentencia->execute(array(':login' => $login, ':id_articulo' => $id_articulo));
    }

}