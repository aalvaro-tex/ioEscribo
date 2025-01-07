<?php
class MyDocumentsService
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new PDO("mysql:host=localhost;dbname=ioescribo", "root", "");
    }
    public function getAllDocuments($login)
    {

        $solicitud = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $solicitud = $this->conexion->prepare("SELECT a.*, uar.id_rol FROM articulo AS a
        JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        JOIN usuario AS u
        ON uar.login = u.email
        WHERE u.email = :login");
        $solicitud->execute(array(':login' => $login));

        $result = $solicitud->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllDocumentsByRol($login, $id_rol)
    {
        $solicitud = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $solicitud = $this->conexion->prepare("SELECT a.*, uar.id_rol FROM articulo AS a
        JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        JOIN usuario AS u
        ON uar.login = u.email
        WHERE u.email = :login AND uar.id_rol = :id_rol");

        $solicitud->execute(array(':login' => $login, ':id_rol' => $id_rol));


        $result = $solicitud->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDocumentId($titulo, $login)
    {
        $solicitud = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $solicitud = $this->conexion->prepare("SELECT id FROM articulo AS a
        LEFT JOIN usuario_articulo_rol AS uar
        ON a.id = uar.id_articulo
        WHERE a.titulo = :titulo
        AND uar.login = :login");

        $solicitud->execute(array(':titulo' => $titulo, ':login' => $login));

        $result = $solicitud->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new Exception("Error en la petición a base de datos.");
        }
        return $result;
    }

    public function getAllCategories()
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sentencia = $this->conexion->prepare("SELECT * FROM categoria");
        $sentencia->execute();

        $categorias = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        return $categorias;
    }

    public function getRol($id_documento, $login)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("SELECT id_rol FROM usuario_articulo_rol WHERE id_articulo = :id_documento AND login = :login");

        $sentencia->execute(array(':id_documento' => $id_documento, ':login' => $login));
        $result = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function addArticle($titulo, $descripcion, $id_categoria, $contenido, $login)
    {
        // primero añado el articulo a la tabla de articulos
        // la fecha de creacion se genera automaticamente
        $fecha_creacion = date("Y-m-d");
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("INSERT INTO articulo (titulo, descripcion, fecha_creacion, id_categoria, contenido, autor) VALUES 
            (:titulo, :descripcion, :fecha_creacion, :id_categoria, :contenido, :login)");

        $sentencia->execute(array(':titulo' => $titulo, ':descripcion' => $descripcion, ':fecha_creacion' => $fecha_creacion, ':id_categoria' => $id_categoria, ':contenido' => $contenido, ':login' => $login));

        // luego le asigno el rol de creador al usuario
        $sentencia2 = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia2 = $this->conexion->prepare("SELECT id FROM articulo WHERE titulo = :titulo");
        $sentencia2->execute(array(':titulo' => $titulo));
        $id_articulo = $sentencia2->fetch(PDO::FETCH_ASSOC)["id"];
        echo "Id del articulo a añadir" . $id_articulo;
        $id_rol = 1;

        $sentencia3 = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia3 = $this->conexion->prepare("INSERT INTO usuario_articulo_rol (login, id_articulo, id_rol) VALUES 
            (:login, :id_articulo, :id_rol)");

        $sentencia3->execute(array(':login' => $login, ':id_articulo' => $id_articulo, ':id_rol' => $id_rol));

    }

    function deleteArticle($id_articulo)
    {
        // Elimina el articulo de la tabla de relacion usuario_articulo_rol
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("DELETE FROM usuario_articulo_rol WHERE id_articulo = :id_articulo");
        $sentencia->execute(array(':id_articulo' => $id_articulo));
        // Elimina el articulo de la tabla de articulos
        $sentencia2 = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia2 = $this->conexion->prepare("DELETE FROM articulo WHERE id = :id_articulo");
        $sentencia2->execute(array(':id_articulo' => $id_articulo));
    }

    public function updateArticle($id_articulo, $descripcion, $titulo, $id_categoria, $contenido)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("UPDATE articulo 
        SET descripcion = :descripcion, titulo = :titulo, id_categoria = :id_categoria, contenido = :contenido
        WHERE id = :id_articulo");
        echo $id_articulo . "" . $descripcion . "" . $titulo . "" . $id_categoria . "" . $contenido . "";
        $sentencia->execute(array(':id_articulo' => $id_articulo, ':descripcion' => $descripcion, ':titulo' => $titulo, ':id_categoria' => $id_categoria, ':contenido' => $contenido));
    }
}

