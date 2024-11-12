<?php

class EditPermissionsService
{

    private $conexion;
    private $id_articulo;
    public function __construct($id_articulo)
    {
        $this->conexion = new ConexionBD();
        $this->id_articulo = $id_articulo;
    }

    public function getCollaborators($id_articulo)
    {
        $collab_query = "SELECT u.* FROM USUARIO AS u
        JOIN usuario_articulo_rol AS uar
        ON u.email = uar.login
        JOIN rol AS r
        ON uar.id_rol = r.id
        WHERE uar.id_articulo = '$id_articulo'
        and r.nombre = 'COLABORADOR'";
        $result = $this->conexion->query($collab_query);
        return $result;
    }

    public function getArticuloById($id_articulo)
    {
        $articulo_query = "SELECT a.*, u.nombre AS Unombre FROM articulo AS a
        JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        JOIN usuario AS u 
        ON uar.login = u.email
        WHERE id = '$id_articulo'
        AND uar.id_rol = 1";
        $result = $this->conexion->query($articulo_query);
        return mysqli_fetch_object($result);
    }

    public function addCollab($login, $id_articulo)
    {
        $add_collab_query = "INSERT INTO usuario_articulo_rol (login, id_articulo, id_rol) VALUES ('$login', '$id_articulo', 2)";
        $result = $this->conexion->query($add_collab_query);
    }

    public function removeCollab($login, $id_articulo)
    {
        $remove_collab_query = "DELETE FROM usuario_articulo_rol WHERE login = '$login' AND id_articulo = '$id_articulo'";

        $result = $this->conexion->query($remove_collab_query);
    }

}