<?php
// index.php - Formulario inicial para cotizador
session_start();
if (
    \$_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset(\$_POST['site_type'])
) {
    // Guardar selección y redirigir a siguiente paso
    \$_SESSION['site_type'] = \$_POST['site_type'];
    header('Location: options.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotizador Web</title>
</head>
<body>
    <h1>Cotizador de Sitio Web</h1>
    <form method="post" action="">
        <p>¿Qué tipo de proyecto desea?</p>
        <label>
            <input type="radio" name="site_type" value="static" required>
            Página Estática (Q899)
        </label><br>
        <label>
            <input type="radio" name="site_type" value="store">
            Tienda en Línea (Q1499)
        </label><br><br>
        <button type="submit">Siguiente</button>
    </form>
</body>
</html>

<?php
// options.php - Paso de selección de extras
session_start();
if (!isset(\$_SESSION['site_type'])) {
    header('Location: index.php');
    exit;
}
// Precios base
\$prices = [
    'static' => 899,
    'store'  => 1499
];
// Opciones adicionales (ejemplo)
\$extras = [
    'seo'       => ['label' => 'SEO básico',      'price' => 200],
    'design'    => ['label' => 'Diseño personalizado', 'price' => 300],
    'hosting'   => ['label' => 'Hosting 1 año',      'price' => 150],
];
if (
    \$_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset(\$_POST['extras'])
) {
    \$_SESSION['extras'] = \$_POST['extras'];
    header('Location: generate_pdf.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Opciones Adicionales</title>
</head>
<body>
    <h1>Extras para su Cotización</h1>
    <p>Selecciones las opciones adicionales:</p>
    <form method="post" action="">
        <?php foreach (\$extras as \$key => \$opt): ?>
            <label>
                <input type="checkbox" name="extras[]" value="<?= \$key ?>">
                <?= \$opt['label'] ?> (Q<?= \$opt['price'] ?>)
            </label><br>
        <?php endforeach; ?>
        <br>
        <button type="submit">Generar PDF</button>
    </form>
</body>
</html>

<?php
// generate_pdf.php - Generación de PDF con FPDF
require_once __DIR__ . '/fpdf/fpdf.php';
session_start();
if (!isset(\$_SESSION['site_type'])) {
    header('Location: index.php');
    exit;
}
// Base de precios
\$prices = ['static' => 899, 'store' => 1499];
\$extras = [
    'seo'     => ['label' => 'SEO básico',           'price' => 200],
    'design'  => ['label' => 'Diseño personalizado', 'price' => 300],
    'hosting' => ['label' => 'Hosting 1 año',       'price' => 150],
];
// Calcular totales
\$total = \$prices[\$_SESSION['site_type']];
\$items = [[
    'desc'  => (\$_SESSION['site_type'] === 'static' ? 'Página Estática' : 'Tienda en Línea'),
    'price' => \$prices[\$_SESSION['site_type']]
]];
if (!empty(\$_SESSION['extras'])) {
    foreach (\$_SESSION['extras'] as \$key) {
        if (isset(\$extras[\$key])) {
            \$items[] = ['desc' => \$extras[\$key]['label'], 'price' => \$extras[\$key]['price']];
            \$total += \$extras[\$key]['price'];
        }
    }
}

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Cotizacion de Sitio Web',0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
foreach (\$items as \$item) {
    \$pdf->Cell(140,8,\$item['desc'],0,0);
    \$pdf->Cell(0,8,'Q'.number_format(\$item['price'],2),0,1,'R');
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(140,8,'Total',0,0);
$pdf->Cell(0,8,'Q'.number_format(\$total,2),0,1,'R');
// Enviar PDF al navegador
\$pdf->Output('D','cotizacion.pdf');
