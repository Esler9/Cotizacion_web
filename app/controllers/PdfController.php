<?php
// app/controllers/PdfController.php

namespace App\controllers;

use App\models\Quote;

class PdfController
{
    /**
     * Genera y envía al navegador la cotización en PDF con diseño enriquecido.
     */
    public function generate()
    {
        // Validar flujo completo
        if (
            empty($_SESSION['site_type']) ||
            empty($_SESSION['options'])   ||
            empty($_SESSION['client'])
        ) {
            header('Location: /');
            exit;
        }

        // Recuperar datos
        $client     = $_SESSION['client'];
        $quoteModel = new Quote();
        $optionsRaw = $_SESSION['options'];
        $items      = $quoteModel->calculate(
            $_SESSION['site_type'],
            $optionsRaw
        );
        $total = array_sum(array_column($items, 'price'));

        // Mapeo de etiquetas para resumen
        $optsDef = $quoteModel->getOptions();
        $siteMap = [
            'informativa' => 'Página Informativa',
            'ecommerce'   => 'Página Ecommerce',
            'scalable'    => 'Sitio Web Escalable'
        ];
        $siteTypeLabel = $siteMap[$_SESSION['site_type']];
        $designLabel   = $optsDef['design'][$optionsRaw['design']]['label'];

        $extrasLabels = [];
        if (!empty($optionsRaw['extras'])) {
            foreach ($optionsRaw['extras'] as $eid) {
                $extrasLabels[] = $optsDef['extras'][$eid]['label'];
            }
        }
        $extraPages    = (int)$optionsRaw['extra_pages'];

        $productsLabel = '';
        if (isset($optionsRaw['products_range'])) {
            $productsLabel  = $optsDef['products_range'][$optionsRaw['products_range']]['label'];
            $extraProducts  = (int)$optionsRaw['extra_products'];
        }

        $seoLabel      = $optsDef['seo'][$optionsRaw['seo']]['label'];
        $brandingLabel = $optsDef['branding'][$optionsRaw['branding']]['label'];
        $domainLabel   = $optsDef['domain'][$optionsRaw['domain']]['label'];
        $hostingLabel  = $optsDef['hosting'][$optionsRaw['hosting']]['label'];

        // Instanciar FPDF
        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

        // Header con fondo y título
        $pdf->SetFillColor(52, 152, 219);
        $pdf->Rect(0, 0, 210, 20, 'F');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, utf8_decode('Cotización de Sitio Web'), 0, 1, 'C');
        $pdf->Ln(4);

        // Resumen de selección
        $pdf->SetTextColor(44, 62, 80);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 7, utf8_decode('Resumen de Selección'), 0, 1);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 6, utf8_decode('Tipo de Sitio: ' . $siteTypeLabel), 0, 1);
        $pdf->Cell(0, 6, utf8_decode('Diseño: ' . $designLabel), 0, 1);
        if ($extrasLabels) {
            $pdf->Cell(0, 6, utf8_decode('Extras de Páginas: ' . implode(', ', $extrasLabels)), 0, 1);
        }
        if ($extraPages > 0) {
            $pdf->Cell(0, 6, utf8_decode('Páginas Adicionales: ' . $extraPages), 0, 1);
        }
        if ($productsLabel) {
            $pdf->Cell(0, 6, utf8_decode('Productos: ' . $productsLabel), 0, 1);
            if (!empty($extraProducts)) {
                $pdf->Cell(0, 6, utf8_decode('Productos Adicionales: ' . $extraProducts), 0, 1);
            }
        }
        $pdf->Cell(0, 6, utf8_decode('SEO: ' . $seoLabel), 0, 1);
        $pdf->Cell(0, 6, utf8_decode('Branding: ' . $brandingLabel), 0, 1);
        $pdf->Cell(0, 6, utf8_decode('Dominio: ' . $domainLabel), 0, 1);
        $pdf->Cell(0, 6, utf8_decode('Hosting: ' . $hostingLabel), 0, 1);
        $pdf->Ln(6);

        // Tabla de ítems
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(130, 7, utf8_decode('Concepto'), 1, 0, 'C');
        $pdf->Cell(50, 7, utf8_decode('Precio (Q)'), 1, 1, 'C');
        $pdf->SetFont('Arial', '', 11);
        foreach ($items as $it) {
            $pdf->MultiCell(130, 6, utf8_decode($it['desc']), 1);
            $height = 6 * (substr_count($it['desc'], "\n") + 1);
            $y = $pdf->GetY() - $height;
            $pdf->SetXY(140, $y);
            $pdf->Cell(50, $height, 'Q' . number_format($it['price'], 2), 1, 1, 'R');
        }

        // Total
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(130, 7, utf8_decode('Total'), 1, 0, 'R');
        $pdf->Cell(50, 7, 'Q' . number_format($total, 2), 1, 1, 'R');

        // Términos y Condiciones
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, utf8_decode('Términos y Condiciones'), 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $policies = [
            'Esta cotización es válida por 30 días a partir de la fecha de emisión.',
            'El pago inicial del 50% garantiza el inicio del proyecto.',
            'Los tiempos de entrega se acordarán en el contrato final.',
            'Cualquier ajuste fuera del alcance descrito será cotizado por separado.'
        ];
        foreach ($policies as $line) {
            $pdf->MultiCell(0, 5, utf8_decode('• ' . $line), 0, 'L');
        }

        // Forzar descarga
        $pdf->Output('D', 'cotizacion.pdf');
        exit;
    }
}
