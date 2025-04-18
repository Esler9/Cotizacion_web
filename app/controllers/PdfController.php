<?php
// app/controllers/PdfController.php

namespace App\controllers;

use App\models\Quote;

// Asegúrate de tener cargado el autoload de Composer
require_once __DIR__ . '/../../vendor/autoload.php';

class PdfController
{
    /**
     * Genera y envía al navegador la cotización en PDF con diseño enriquecido.
     */
    public function generate()
    {
        // Validar que todo el flujo esté completo
        if (
            empty($_SESSION['site_type']) ||
            empty($_SESSION['options'])   ||
            empty($_SESSION['client'])
        ) {
            header('Location: /');
            exit;
        }

        // Recuperar datos
        $client = $_SESSION['client'];
        $quoteModel = new Quote();
        $items = $quoteModel->calculate(
            $_SESSION['site_type'],
            $_SESSION['options']
        );
        $total = array_sum(array_column($items, 'price'));

        // Extiende FPDF para header/footer
        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 20);

        // Header
        $pdf->SetFillColor(52, 152, 219);             // Celeste
        $pdf->Rect(0, 0, 210, 20, 'F');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, 'Cotización de Sitio Web', 0, 1, 'C');
        $pdf->Ln(5);

        // Datos del cliente
        $pdf->SetTextColor(44, 62, 80);                // Azul oscuro
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, 'Información de Cliente', 0, 1);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 6, 'Nombre: ' . $client['name'], 0, 1);
        $pdf->Cell(0, 6, 'Email:  ' . $client['email'], 0, 1);
        if (!empty($client['phone'])) {
            $pdf->Cell(0, 6, 'Tel:    ' . $client['phone'], 0, 1);
        }
        $pdf->Ln(8);

        // Tabla de ítems
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(44, 62, 80);
        $pdf->Cell(130, 7, 'Concepto', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Precio (Q)', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 11);
        foreach ($items as $it) {
            // Descripción multiline
            $pdf->MultiCell(130, 6, $it['desc'], 1);
            // Posiciona el precio al lado
            $x = $pdf->GetX();
            $y = $pdf->GetY() - 6 * substr_count($it['desc'], "\n") - 6;
            $pdf->SetXY(140, $y);
            $pdf->Cell(50, 6 * (substr_count($it['desc'], "\n") + 1),
                       'Q' . number_format($it['price'], 2),
                       1, 0, 'R');
            $pdf->Ln(0);
        }

        // Total
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(130, 7, 'Total', 1, 0, 'R');
        $pdf->Cell(50, 7, 'Q' . number_format($total, 2), 1, 1, 'R');

        // Políticas y términos
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, 'Términos y Condiciones', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $policies = [
            'Esta cotización es válida por 30 días a partir de la fecha de emisión.',
            'El pago inicial del 50% garantiza el inicio del proyecto.',
            'Los tiempos de entrega se acordarán en el contrato final.',
            'Cualquier ajuste fuera del alcance descrito será cotizado por separado.'
        ];
        foreach ($policies as $line) {
            $pdf->MultiCell(0, 5, '• ' . $line, 0, 'L');
        }

        // Forzar descarga
        $pdf->Output('D', 'cotizacion.pdf');
        exit;
    }
}
