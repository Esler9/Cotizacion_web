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
        // 1) Limpiar cualquier buffer de salida para evitar errores de FPDF
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        // 2) Validar que la sesión ya está cargada y contiene lo necesario
        if (
            empty($_SESSION['site_type']) ||
            empty($_SESSION['options'])   ||
            empty($_SESSION['client'])
        ) {
            header('Location: /');
            exit;
        }

        // 3) Recuperar datos de sesión
        $client     = $_SESSION['client'];
        $optionsRaw = $_SESSION['options'];

        // 4) Calcular items y total
        $quoteModel = new Quote();
        $items      = $quoteModel->calculate(
            $_SESSION['site_type'],
            $optionsRaw
        );
        $total = array_sum(array_column($items, 'price'));

        // 5) Extraer labels de las opciones
        $optsDef = $quoteModel->getOptions();
        $findLabel = function(string $group, $id) use ($optsDef): string {
            return $optsDef[$group][$id]['label'] ?? '';
        };

        $siteTypeLabel = [
            'informativa' => 'Página Informativa',
            'ecommerce'   => 'Página Ecommerce',
            'scalable'    => 'Sitio Web Escalable'
        ][$_SESSION['site_type']] ?? $_SESSION['site_type'];

        $designLabel   = $findLabel('design',          $optionsRaw['design'] ?? '');
        $seoLabel      = $findLabel('seo',             $optionsRaw['seo'] ?? '');
        $brandingLabel = $findLabel('branding',        $optionsRaw['branding'] ?? '');
        $domainLabel   = $findLabel('domain',          $optionsRaw['domain'] ?? '');
        $hostingLabel  = $findLabel('hosting',         $optionsRaw['hosting'] ?? '');

        $extrasLabels = [];
        foreach (($optionsRaw['extras'] ?? []) as $eid) {
            if ($lbl = $findLabel('extras', $eid)) {
                $extrasLabels[] = $lbl;
            }
        }
        $extraPages    = (int)($optionsRaw['extra_pages'] ?? 0);

        $productsLabel = $findLabel('products_range',  $optionsRaw['products_range'] ?? '');
        $extraProducts = (int)($optionsRaw['extra_products'] ?? 0);

        // 6) Función para convertir UTF-8 → ISO-8859-1 para FPDF
        $u = fn(string $text): string => mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');

        // 7) Generar PDF
        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

        // Header
        $pdf->SetFillColor(52, 152, 219);
        $pdf->Rect(0, 0, 210, 20, 'F');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, $u('Cotización de Sitio Web'), 0, 1, 'C');
        $pdf->Ln(4);

        // Resumen de selección
        $pdf->SetTextColor(44, 62, 80);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 7, $u('Resumen de Selección'), 0, 1);
        $pdf->SetFont('Arial', '', 11);

        $pdf->Cell(0, 6, $u("Tipo de Sitio: {$siteTypeLabel}"), 0, 1);
        $pdf->Cell(0, 6, $u("Diseño: {$designLabel}"), 0, 1);
        if ($extrasLabels) {
            $pdf->Cell(0, 6, $u('Extras Páginas: '.implode(', ', $extrasLabels)), 0, 1);
        }
        if ($extraPages > 0) {
            $pdf->Cell(0, 6, $u("Páginas Adicionales: {$extraPages}"), 0, 1);
        }
        if ($productsLabel) {
            $pdf->Cell(0, 6, $u("Productos: {$productsLabel}"), 0, 1);
            if ($extraProducts > 0) {
                $pdf->Cell(0, 6, $u("Productos Adic.: {$extraProducts}"), 0, 1);
            }
        }
        $pdf->Cell(0, 6, $u("SEO: {$seoLabel}"), 0, 1);
        $pdf->Cell(0, 6, $u("Branding: {$brandingLabel}"), 0, 1);
        $pdf->Cell(0, 6, $u("Dominio: {$domainLabel}"), 0, 1);
        $pdf->Cell(0, 6, $u("Hosting: {$hostingLabel}"), 0, 1);
        $pdf->Ln(6);

        // Tabla de ítems
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(130, 7, $u('Concepto'), 1, 0, 'C');
        $pdf->Cell(50, 7, $u('Precio (Q)'), 1, 1, 'C');
        $pdf->SetFont('Arial', '', 11);

        foreach ($items as $it) {
            $desc = $u($it['desc']);
            $pdf->MultiCell(130, 6, $desc, 1);
            $height = 6 * (substr_count($desc, "\n") + 1);
            $y = $pdf->GetY() - $height;
            $pdf->SetXY(140, $y);
            $pdf->Cell(50, $height, 'Q'.number_format($it['price'],2), 1, 1, 'R');
        }

        // Total
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(130, 7, $u('Total'), 1, 0, 'R');
        $pdf->Cell(50, 7, 'Q'.number_format($total,2), 1, 1, 'R');

        // Términos y Condiciones
        $pdf->Ln(8);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0, 6, $u('Términos y Condiciones'), 0, 1);
        $pdf->SetFont('Arial','',10);
        $policies = [
            'Cotización válida por 30 días desde la emisión.',
            'Pago inicial 50% para comenzar el proyecto.',
            'Tiempos de entrega sujetos a contrato final.',
            'Extras fuera del alcance serán cotizados a parte.'
        ];
        foreach ($policies as $line) {
            $pdf->MultiCell(0,5,$u('• '.$line),0,'L');
        }

        // Descargar PDF
        $pdf->Output('D','cotizacion.pdf');
        exit;
    }
}
