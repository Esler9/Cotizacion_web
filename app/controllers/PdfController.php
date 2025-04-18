<?php
namespace App\controllers;

use App\models\Quote;

class PdfController
{
    /**
     * Genera y envía al navegador la cotización en PDF.
     */
    public function generate()
    {
        // Validar flujo
        if (empty($_SESSION['site_type']) || empty($_SESSION['options'])) {
            header('Location: /');
            exit;
        }

        // Calcular ítems
        $quote = new Quote();
        $items = $quote->calculate(
            $_SESSION['site_type'],
            $_SESSION['options']
        );

        // Instanciar FPDF (clase global)
        $pdf = new \FPDF();
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

        // Forzar descarga
        $pdf->Output('D', 'cotizacion.pdf');
        exit;
    }
}
