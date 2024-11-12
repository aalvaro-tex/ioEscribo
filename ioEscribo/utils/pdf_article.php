<?php
require('fpdf.php');
include('../services/edit-permissions-service.php');
include("../controllers/conexion_bd.php");
session_start();
class pdfArticle extends FPDF
{
    public $titulo;
    public $autor;
    public $descripcion;
    public $contenido;
    public $categoria;
    public $fecha_creacion;
    public $colaboradores;
    private $editPermissionsService;

    private $id_articulo;

    public function __construct($titulo, $autor, $descripcion, $contenido, $categoria, $fecha_creacion, $id_articulo)
    {
        parent::__construct();
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->descripcion = $descripcion;
        $this->contenido = $contenido;
        $this->categoria = $categoria;
        $this->fecha_creacion = $fecha_creacion;
        $this->id_articulo = $id_articulo;
        $this->editPermissionsService = new EditPermissionsService($id_articulo);
        $this->colaboradores = $this->editPermissionsService->getCollaborators($id_articulo);
    }

    // Cabecera de página
    function Header()
    {
        // Ajuste de los márgenes
        $this->SetAutoPageBreak(true);
        $this->Image('../assets/img/fondo_pdf.png',0,0,$this->w, $this->h);
        // Logo
        $this->Image('../assets/img/ioEscribo_logo.png', 10, 8, 33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(80);
        // Cabecera
        $this->Cell(30, 8, 'Solicitud de descarga', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
        // Información del sistema
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 5, "Has solicitado la descarga de un articulo de nuestra plataforma. Recuerda que no debes compartir este documento sin el permiso de su autor.", 0, 1);
        // Línea divisoria
        $this->Ln(1);
        $this->SetFillColor(0, 0, 0);
        $this->Cell(0, 0.5, "", 0, 1, 'L', true);
    }

    // Pie de página
    function Footer()
    {
        $this->SetAutoPageBreak(true);
        // Posición: a 1,5 cm del final
        $this->SetY(-30);
        $this->SetFont('Arial', 'B', 10);
        $collabs = $this->editPermissionsService->getCollaborators($this->id_articulo);
        if ($collabs) {
            $this->Cell(0, 10, 'Han colaborado en la edicion de este articulo: ', 0, 1, 'L');
            $this->SetFont('Arial', 'I', 8);
            foreach ($collabs as $row) {
                $this->Cell(0, 5, "Colaborador: " . $row["nombre"], 0, 1, 'L');
            }
        }
    }
}

if (isset($_POST['download-article'])) {
    $pdf = new pdfArticle(
        $_POST['titulo-descarga'],
        $_POST['autor-descarga'],
        $_POST['descripcion-descarga'],
        $_POST['contenido-descarga'],
        $_POST['categoria-descarga'],
        $_POST['fecha-descarga'],
        $_POST['id-articulo-descarga']
    );
    $pdf->SetTitle(utf8_decode($_POST['titulo-descarga']) . "-ioEscribo");
    $pdf->AddPage();
    // Título
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, utf8_decode($pdf->titulo), 0, 2, 'L');
    // Autor
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(40, 5, "Por " . utf8_decode($pdf->autor) . ", a " . $pdf->fecha_creacion, 0, 2, 'L');
    // Descripcion
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, utf8_decode($pdf->descripcion), 0, 2, 'L');
    // Contenido
    $pdf->SetFont('Arial', '', 11);
    $pdf->MultiCell(0, 5, utf8_decode($pdf->contenido));
    $pdf->Output();
}