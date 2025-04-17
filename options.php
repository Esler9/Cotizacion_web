<?php
session_start();
if (!isset($_SESSION['site_type'])) {
    header('Location: index.php');
    exit;
}
$options = [
    'design' => [
        ['id'=>'personalizado','label'=>'Diseño Personalizado','price'=>400],
        ['id'=>'basica','label'=>'Plantilla Básica Incluida','price'=>0]
    ],
    'extras' => [
        ['id'=>'perfil','label'=>'Perfil de Usuario','price'=>200],
        ['id'=>'login','label'=>'Login de Usuario','price'=>150],
        ['id'=>'busqueda','label'=>'Resultado de Búsqueda','price'=>150]
    ],
    'seo' => [
        ['id'=>'basico','label'=>'SEO Básico (Incluido)','price'=>0],
        ['id'=>'intermedio','label'=>'SEO Intermedio','price'=>300],
        ['id'=>'avanzado','label'=>'SEO Avanzado','price'=>950]
    ],
    'branding' => [
        ['id'=>'logo_basico','label'=>'Logotipo Básico: 3 Variaciones, 5 iconos','price'=>350],
        ['id'=>'icono_profesional','label'=>'Icono Profesional (PNG, PDF, PSD, AI, mockups)','price'=>2300]
    ],
    'hosting' => [
        ['id'=>'dominio','label'=>'Dominio (.com)','price'=>250],
        ['id'=>'compartido','label'=>'Hosting Compartido','price'=>250],
        ['id'=>'profesional','label'=>'Hosting Profesional','price'=>800],
        ['id'=>'avanzado','label'=>'Hosting Avanzado','price'=>1300]
    ]
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['options'] = $_POST;
    header('Location: generate_pdf.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Opciones Adicionales</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>Selecciona tus Opciones</h1>
    <form method="post">

      <div class="section">
        <h2>Tipo de Diseño</h2>
        <?php foreach ($options['design'] as $opt): ?>
          <label class="radio-option">
            <input type="radio" name="design" value="<?= $opt['id']; ?>" required>
            <span><?= $opt['label']; ?><?php if($opt['price']>0) echo " (Q".number_format($opt['price'],2).")"; ?></span>
          </label>
        <?php endforeach; ?>
      </div>

      <div class="section">
        <h2>Páginas Adicionales</h2>
        <?php foreach ($options['extras'] as $opt): ?>
          <label class="checkbox-option">
            <input type="checkbox" name="extras[]" value="<?= $opt['id']; ?>">
            <span><?= $opt['label']; ?> (Q<?= number_format($opt['price'],2); ?>)</span>
          </label><br>
        <?php endforeach; ?>
        <label class="form-group">
          <span>Otras páginas avanzadas (Q100 p/u):</span>
          <input type="number" name="extra_pages" min="0" value="0">
        </label>
      </div>

      <div class="section">
        <h2>SEO</h2>
        <?php foreach ($options['seo'] as $opt): ?>
          <label class="radio-option">
            <input type="radio" name="seo" value="<?= $opt['id']; ?>" <?php echo $opt['id']==='basico'?'checked':''; ?>>
            <span><?= $opt['label']; ?><?php if($opt['price']>0) echo " (Q".number_format($opt['price'],2).")"; ?></span>
          </label>
        <?php endforeach; ?>
      </div>

      <div class="section">
        <h2>Branding</h2>
        <?php foreach ($options['branding'] as $opt): ?>
          <label class="radio-option">
            <input type="radio" name="branding" value="<?= $opt['id']; ?>">
            <span><?= $opt['label']; ?> (Q<?= number_format($opt['price'],2); ?>)</span>
          </label>
        <?php endforeach; ?>
      </div>

      <div class="section">
        <h2>Dominio y Hosting</h2>
        <?php foreach ($options['hosting'] as $opt): ?>
          <label class="radio-option">
            <input type="radio" name="hosting" value="<?= $opt['id']; ?>">
            <span><?= $opt['label']; ?> (Q<?= number_format($opt['price'],2); ?>)</span>
          </label>
        <?php endforeach; ?>
      </div>

      <div class="form-group">
        <label>
          <span>Productos (50 incluidos, +50 = Q100):</span>
          <input type="number" name="products" step="50" min="50" value="50">
        </label>
      </div>

      <button type="submit" class="btn">Generar Cotización</button>
    </form>
  </div>
</body>
</html>