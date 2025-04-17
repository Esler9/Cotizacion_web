<?php
namespace App\controllers;

use App\models\Quote;
use setasign\Fpdf\Fpdf;

class PdfController
{
    public function generate()
    {
        // Validación mínima
        if (!isset($_SESSION['site_type'], $_SESSION['options'])) {
            header('Location: /');
            exit;
        }

        // Calculamos ítems y generamos PDF
        $quote = new Quote();
        $items = $quote->calculate($_SESSION['site_type'], $_SESSION['options']);

        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,10,'Cotizacion de Sitio Web',0,1,'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial','',12);
        $total = 0;
        foreach ($items as $it) {
            $pdf->Cell(140,8,$it['desc'],0,0);
            $pdf->Cell(0,8,'Q'.number_format($it['price'],2),0,1,'R');
            $total += $it['price'];
        }

        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(140,8,'Total',0,0);
        $pdf->Cell(0,8,'Q'.number_format($total,2),0,1,'R');

        $pdf->Output('D','cotizacion.pdf');
        exit;
    }
}
