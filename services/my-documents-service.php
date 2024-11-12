<?php
class MyDocumentsService
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new ConexionBD();
    }
    public function getAllDocuments($login)
    {
        $all_documents_query = "SELECT a.*, uar.id_rol FROM articulo AS a
        JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        JOIN usuario AS u
        ON uar.login = u.email
        WHERE u.email = '$login'";

        $result = $this->conexion->query($all_documents_query);
        return $result;
    }

    public function getAllDocumentsByRol($login, $id_rol)
    {
        $all_documents_query = "SELECT a.*, uar.id_rol FROM articulo AS a
        JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        JOIN usuario AS u
        ON uar.login = u.email
        WHERE u.email = '$login' AND uar.id_rol = '$id_rol'";

        $result = $this->conexion->query($all_documents_query);
        return $result;
    }

    public function getDocumentId($titulo, $login)
    {
        $id_documento_query = "SELECT id FROM articulo AS a
        LEFT JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        WHERE a.titulo = '$titulo'
        AND uar.login = '$login'";

        $result = $this->conexion->query($id_documento_query);
        if (!$result) {
            throw new Exception("Error en la petición a base de datos.");
        }
        return $result;
    }

    public function getAllCategories()
    {
        $all_categories_query = "SELECT * FROM categoria";

        $result = $this->conexion->query($all_categories_query);
        return $result;
    }

    public function getRol($id_documento, $login)
    {
        $rol_query = "SELECT id_rol FROM usuario_articulo_rol WHERE id_articulo = $id_documento AND login = '$login'";

        $result = $this->conexion->query($rol_query);
        return mysqli_fetch_object($result);
    }

    public function addArticle($titulo, $descripcion, $id_categoria, $contenido, $login)
    {
        // primero añado el articulo a la tabla de articulos

        // la fecha de creacion se genera automaticamente
        $fecha_creacion = date("Y-m-d");
        $query = "INSERT INTO articulo (titulo, descripcion, fecha_creacion, id_categoria, contenido, autor) VALUES 
            ('$titulo', '$descripcion', '$fecha_creacion', '$id_categoria', '$contenido', '$login')";

        $this->conexion->query($query);

        // luego le asigno el rol de creador al usuario
        $id_articulo = $this->conexion->query("SELECT id FROM articulo WHERE titulo = '$titulo'")->fetch_object()->id;
        echo "Id del articulo a añadir" . $id_articulo;
        $id_rol = 1;

        $query = "INSERT INTO usuario_articulo_rol (login, id_articulo, id_rol) VALUES 
        ('$login', '$id_articulo', '$id_rol')";

        $this->conexion->query($query);
    }

    function deleteArticle($id_articulo)
    {
        // Elimina el articulo de la tabla de relacion usuario_articulo_rol
        $query = "DELETE FROM usuario_articulo_rol WHERE id_articulo = $id_articulo";
        $this->conexion->query($query);
        // Elimina el articulo de la tabla de articulos
        $query = "DELETE FROM articulo WHERE id = $id_articulo";
        $this->conexion->query($query);
    }

    public function updateArticle($id_articulo, $descripcion, $titulo, $id_categoria, $contenido)
    {
        $query = "UPDATE articulo 
        SET descripcion = '$descripcion', titulo = '$titulo', id_categoria = '$id_categoria', contenido = '$contenido' 
        WHERE id = '$id_articulo'";
        echo $id_articulo . "" . $descripcion . "" . $titulo . "" . $id_categoria . "" . $contenido . "";
        $this->conexion->query($query);
    }
}

