<?php
include("edit-permissions-service.php");
class MyNotificationsService
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = new ConexionBD();
    }

    public function getSolicitudes($login)
    {
        $notifications_query = "SELECT s.*, a.titulo FROM solicitud AS s
        JOIN articulo AS a 
        ON s.id_articulo = a.id
        WHERE s.autor='$login' 
        AND s.estado='PENDIENTE'";
        $result = $this->conexion->query($notifications_query);
        return $result;
    }

    public function countPendingNotifications($login)
    {
        $count_query = "SELECT COUNT(*) AS count FROM solicitud 
        WHERE autor='$login' AND estado='PENDIENTE'";
        $result = $this->conexion->query($count_query);
        return $result;
    }

    public function addSolicitud($login, $id_articulo, $autor)
    {
        $add_solicitud_query = "INSERT INTO solicitud (solicitante, autor, id_articulo) 
        VALUES ('$login', '$autor', '$id_articulo', 'PENDIENTE')";
        $result = $this->conexion->query($add_solicitud_query);
        return $result;
    }

    public function acceptRequest($id_solicitud)
    {
        $accept_query = "UPDATE solicitud SET estado='ACEPTADA' WHERE id='$id_solicitud'";
        $this->conexion->query($accept_query);

        // hay que añadir al usuario a la tabla de colaboradores
        $query = $this->conexion->query("SELECT * FROM solicitud WHERE id='$id_solicitud'");
        $solicitud = mysqli_fetch_object($query);

        echo "Solicitud: " . $solicitud->id_articulo . " solicitante " . $solicitud->solicitante;
        $editPermissionsService = new EditPermissionsService($solicitud->id_articulo);
        $editPermissionsService->addCollab($solicitud->solicitante, $solicitud->id_articulo);

    }

    public function rejectSolicitud($id_solicitud)
    {
        $delete_query = "UPDATE solicitud SET estado='RECHAZADA' WHERE id='$id_solicitud'";
        $result = $this->conexion->query($delete_query);
        return $result;
    }

    public function getMyOtherNotifications($login){
        $other_notifications_query = "SELECT s.*, a.titulo FROM solicitud AS s
        JOIN articulo AS a 
        ON s.id_articulo = a.id
        WHERE s.solicitante='$login' 
        AND s.estado NOT LIKE 'PENDIENTE' ";
        $result = $this->conexion->query($other_notifications_query);
        return $result;
    }

}