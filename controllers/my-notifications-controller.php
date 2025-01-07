<?php

include("controllers/conexion_bd.php");
include("services/my-notifications-service.php");

class MyNotificationsController
{

    private $myNotificationsService;

    public function __construct()
    {
        $this->myNotificationsService = new MyNotificationsService();
    }

    public function getNotifications()
    {
        return $this->myNotificationsService->getSolicitudes($_SESSION["correo"]);
    }

    public function countPendingNotifications()
    {
        return $this->myNotificationsService->countPendingNotifications($_SESSION["correo"]);
    }

    public function addRequest($id_articulo, $autor)
    {
        return $this->myNotificationsService->addSolicitud($_SESSION["correo"], $id_articulo, $autor);
    }

    public function acceptRequest($id_solicitud)
    {
        return $this->myNotificationsService->acceptRequest($id_solicitud);
    }

    public function rejectRequest($id_articulo)
    {
        return $this->myNotificationsService->rejectSolicitud($id_articulo);
    }
    // devuelve la lista de peticiones que hemos realizado y ya han sido aceptadas o rechazadas
    public function getMyOtherNotifications()
    {
        return $this->myNotificationsService->getMyOtherNotifications($_SESSION["correo"]);
    }

}

if (isset($_POST["accept-request"])) {
    $myNotificationsController = new MyNotificationsController();
    $checkedIdSolicitud = htmlspecialchars($_POST["id_solicitud"]);
    $myNotificationsController->acceptRequest($checkedIdSolicitud);
}

if (isset($_POST["reject-request"])) {
    $myNotificationsController = new MyNotificationsController();
    $checkedIdSolicitud = htmlspecialchars($_POST["id_solicitud"]);
    $myNotificationsController->rejectRequest($checkedIdSolicitud);
}