<?php
require 'fpdf/fpdf.php';
session_start();
if (!isset($_SESSION['site_type'], $_SESSION['options'])) {
    header('Location: index.php');
    exit;
}

// Precios base
$base_prices = ['informativa'=>400, 'ecommerce'=>800, 'scalable'=>3999];

// Constantes
defined('Q_PER_EXTRA_PAGE') or define('Q_PER_EXTRA_PAGE', 100);
defined('Q_PER_EXTRA_PRODUCTS') or define('Q_PER_EXTRA_PRODUCTS', 100);

// Precios adicionales (mapeo)
$map = [
    'design_basica'=>0,
    'design_personalizado'=>400,
    'design_profesional'=>1500,
    'extras_perfil'=>200,
    'extras_login'=>150,
    'extras_busqueda'=>150,
    'products_range_50'=>0,
    'products_range_50-200'=>250,
    'products_range_200-500'=>650,
    'products_range_500-1000'=>1450,
    'seo_basico'=>0,
    'seo_intermedio'=>300,
    'seo_avanzado'=>950,
    'branding_none'=>0,
    'branding_logo_basico'=>350,
    'branding_icono_profesional'=>2300,
    'domain_none'=>0,
    'domain_dominio'=>250,
    'hosting_none'=>0,
    'hosting_compartido'=>250,
    'hosting_profesional'=>800,
    'hosting_avanzado'=>1300
];

// Armar items y total
$items = [];
$total = 0;
$type = $_SESSION['site_type'];
$items[] = ['desc'=>"Tipo de sitio: " . ucfirst($type), 'price'=>$base_prices[$type]];
$total += $base_prices[$type];

foreach ($_SESSION['options'] as $group => $val) {
    if (is_array($val)) {
        foreach ($val as $v) {
            $key = "{$group}_{$v}";
            if (isset($map[$key])) {
                $items[] = ['desc'=> ucfirst(str_replace(["_","-"]," ",$v)) , 'price'=>$map[$key]];
                $total += $map[$key];
            }
        }
    } else {
        $key = "{$group}_{$val}";
        if (isset($map[$key])) {
            $items[] = ['desc'=> ucfirst(str_replace(["_","-"]," ",$val)) , 'price'=>$map[$key]];
            $total += $map[$key];
        }
    }
}

// Extra páginas
$extra_pages = (int)($_SESSION['options']['extra_pages'] ?? 0);
if ($extra_pages > 0) {
    $items[] = ['desc'=>"Páginas extra ($extra_pages)", 'price'=>Q_PER_EXTRA_PAGE * $extra_pages];
    $total += Q_PER_EXTRA_PAGE * $extra_pages;
}

// Extra productos
$extra_products = (int)($_SESSION['options']['extra_products'] ?? 0);
if ($extra_products > 0) {
    $blocks = $extra_products / 50;
    $items[] = ['desc'=>"Productos extra (".$extra_products.")", 'price'=>Q_PER_EXTRA_PRODUCTS * $blocks];
    $total += Q_PER_EXTRA_PRODUCTS * $blocks;
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

$pdf->Output('D','cotizacion.pdf');