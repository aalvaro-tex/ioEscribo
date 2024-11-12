<?php
include("services/logout-service.php");
include("controllers/conexion_bd.php");
class LogoutController
{

    private $logoutService;

    public function __construct()
    {
        $this->logoutService = new LogoutService();
    }

    public function logout()
    {
        $this->logoutService->logout();
    }
}