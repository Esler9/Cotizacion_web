
<?php
require 'fpdf/fpdf.php';
session_start();
// Validar flujo
if (!isset($_SESSION['site_type'], $_SESSION['options'])) {
    header('Location: index.php');
    exit;
}

// Precios base según tipo
$base_prices = ['informativa'=>200, 'ecommerce'=>400];

// Definir extras con sus precios
defined('EXTRA_PER_PAGE') or define('EXTRA_PER_PAGE', 100);
defined('EXTRA_PER_50_PRODUCTS') or define('EXTRA_PER_50_PRODUCTS', 100);

// Mapeo de todos los precios
define('PRICES', [
    'design_personalizado' => 400,
    'branding_logo_basico' => 350,
    'branding_icono_profesional' => 2300,
    'seo_intermedio' => 300,
    'seo_avanzado' => 950,
    'hosting_dominio' => 250,
    'hosting_compartido' => 250,
    'hosting_profesional' => 800,
    'hosting_avanzado' => 1300,
    'extras_perfil' => 200,
    'extras_login' => 150,
    'extras_busqueda' => 150
]);

// Armar items y calcular total
$items = [];
$total = 0;

// Base
$type = $_SESSION['site_type'];
$items[] = ['desc'=>"Tipo de página: $type", 'price'=>$base_prices[$type]];
$total += $base_prices[$type];

// Opciones seleccionadas
foreach ($_SESSION['options'] as $group => $selections) {
    if (!is_array($selections)) continue;
    foreach ($selections as $sel) {
        $key = "{$group}_{$sel}";
        if (isset(PRICES[$key])) {
            $items[] = ['desc'=>ucfirst($sel), 'price'=>PRICES[$key]];
            $total += PRICES[$key];
        }
    }
}

// Páginas adicionales
$extra_pages = (int)($_SESSION['options']['extra_pages'] ?? 0);
if ($extra_pages>0) {
    $items[] = ['desc'=>"Páginas adicionales ($extra_pages)", 'price'=>EXTRA_PER_PAGE*$extra_pages];
    $total += EXTRA_PER_PAGE*$extra_pages;
}

// Productos extras
$products = (int)($_SESSION['options']['products'] ?? 50);
if ($products>50) {
    $blocks = floor(($products-50)/50);
    $items[] = ['desc'=>"Productos adicionales (".(50*$blocks).")", 'price'=>EXTRA_PER_50_PRODUCTS*$blocks];
    $total += EXTRA_PER_50_PRODUCTS*$blocks;
}

// Generar PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Cotizacion de Sitio Web',0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
foreach ($items as $it) {
    $pdf->Cell(140,8,$it['desc'],0,0);
    $pdf->Cell(0,8,'Q'.number_format($it['price'],2),0,1,'R');
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(140,8,'Total',0,0);
$pdf->Cell(0,8,'Q'.number_format($total,2),0,1,'R');

// Descargar PDF
$pdf->Output('D','cotizacion.pdf');