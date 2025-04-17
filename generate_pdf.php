<?php
require 'fpdf/fpdf.php';
session_start();
if (!isset($_SESSION['site_type'])) {
  header('Location:index.php'); exit;
}
// Precios
$base = ['static'=>899,'store'=>1499];
$extrasList = [
  'seo'=>['label'=>'SEO básico','price'=>200],
  'design'=>['label'=>'Diseño personalizado','price'=>300],
  'hosting'=>['label'=>'Hosting 1 año','price'=>150],
];
// Items y total
$items = [[
  'desc'=>($_SESSION['site_type']=='static'?'Página Estática':'Tienda en Línea'),
  'price'=>$base[$_SESSION['site_type']]
]];
$total = $base[$_SESSION['site_type']];
foreach($_SESSION['extras'] ?? [] as $key){
  if (isset($extrasList[$key])) {
    $items[] = $extrasList[$key];
    $total += $extrasList[$key]['price'];
  }
}
// PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Cotizacion de Sitio Web',0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
foreach($items as $it){
  $pdf->Cell(140,8,$it['label']??$it['desc'],0,0);
  $pdf->Cell(0,8,'Q'.number_format($it['price'],2),0,1,'R');
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(140,8,'Total',0,0);
$pdf->Cell(0,8,'Q'.number_format($total,2),0,1,'R');
$pdf->Output('D','cotizacion.pdf');
