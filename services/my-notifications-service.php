<?php
include("edit-permissions-service.php");
class MyNotificationsService
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = new PDO("mysql:host=localhost;dbname=ioescribo", "root", "");
    }

    public function getSolicitudes($login)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("SELECT s.*, a.titulo FROM solicitud AS s
        JOIN articulo AS a 
        ON s.id_articulo = a.id
        WHERE s.autor=:login
        AND s.estado='PENDIENTE'
        GROUP BY s.solicitante");

        $sentencia->execute(array(':login' => $login));
        $result = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addSolicitud($login, $id_articulo, $autor)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("INSERT INTO solicitud (solicitante, autor, id_articulo) 
        VALUES (:login, :autor, :id_articulo, 'PENDIENTE')");
        $sentencia->execute(array(':login' => $login, ':autor' => $autor, ':id_articulo' => $id_articulo));
        $result = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function acceptRequest($id_solicitud)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("UPDATE solicitud SET estado='ACEPTADA' WHERE id=:id_solicitud");
        $sentencia->execute(array(':id_solicitud' => $id_solicitud));

        // hay que añadir al usuario a la tabla de colaboradores
        $sentencia2 = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia2 = $this->conexion->prepare("SELECT * FROM solicitud WHERE id=:id_solicitud");
        $sentencia2->execute(array(':id_solicitud' => $id_solicitud));
        $solicitud = $sentencia2->fetch(PDO::FETCH_ASSOC);

        echo "Solicitud: " . $solicitud['id_articulo'] . " solicitante " . $solicitud['solicitante'];
        $editPermissionsService = new EditPermissionsService($solicitud['id_articulo']);
        $editPermissionsService->addCollab($solicitud['solicitante'], $solicitud['id_articulo']);

    }

    public function rejectSolicitud($id_solicitud)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("UPDATE solicitud SET estado='RECHAZADA' WHERE id=:id_solicitud");
        $sentencia->execute(array(':id_solicitud' => $id_solicitud));
        $result = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMyOtherNotifications($login)
    {
        $sentencia = $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sentencia = $this->conexion->prepare("SELECT s.*, a.titulo FROM solicitud AS s
        JOIN articulo AS a 
        ON s.id_articulo = a.id
        WHERE s.solicitante=:login
        AND s.estado NOT LIKE 'PENDIENTE' ");
        $sentencia->execute(array(':login' => $login));
        $result = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}