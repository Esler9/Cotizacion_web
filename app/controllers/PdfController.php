<?php
// app/controllers/PdfController.php
namespace App\controllers;

use App\models\Quote;
use setasign\Fpdf\Fpdf;

class PdfController
{
    /**
     * Genera y envía al navegador la cotización en PDF.
     */
    public function generate()
    {
        // Asegura que el usuario completó pasos previos
        if (empty($_SESSION['site_type']) || empty($_SESSION['options'])) {
            header('Location: /');
            exit;
        }

        // Calcula ítems de la cotización
        $quote = new Quote();
        $items = $quote->calculate(
            $_SESSION['site_type'],
            $_SESSION['options']
        );

        // Crear PDF
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Cotización de Sitio Web', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 12);
        $total = 0;
        foreach ($items as $it) {
            $pdf->Cell(140, 8, $it['desc'], 0, 0);
            $pdf->Cell(0, 8, 'Q' . number_format($it['price'], 2), 0, 1, 'R');
            $total += $it['price'];
        }

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(140, 8, 'Total', 0, 0);
        $pdf->Cell(0, 8, 'Q' . number_format($total, 2), 0, 1, 'R');

        // Enviar PDF al cliente (descarga forzada)
        $pdf->Output('D', 'cotizacion.pdf');
        exit;
    }
}
