<?php
session_start();
if (!isset($_SESSION['site_type'])) {
    header('Location: index.php');
    exit;
}
// Precios y opciones definidas
define('Q_PER_EXTRA_PAGE', 100);
define('Q_PER_EXTRA_PRODUCTS', 100);
$options = [
    'design' => [
        ['id'=>'basica','label'=>'Plantilla Básica Incluida','price'=>0],
        ['id'=>'personalizado','label'=>'Diseño Personalizado','price'=>400],
        ['id'=>'profesional','label'=>'Diseño Profesional de Mercadeo','price'=>1500]
    ],
    'extras' => [
        ['id'=>'perfil','label'=>'Perfil de Usuario','price'=>200],
        ['id'=>'login','label'=>'Login de Usuario','price'=>150],
        ['id'=>'busqueda','label'=>'Resultado de Búsqueda','price'=>150]
    ],
    'products_range' => [
        ['id'=>'50','label'=>'50 Productos Incluidos','price'=>0],
        ['id'=>'50-200','label'=>'50 - 200 Productos','price'=>250],
        ['id'=>'200-500','label'=>'200 - 500 Productos','price'=>650],
        ['id'=>'500-1000','label'=>'500 - 1000 Productos','price'=>1450]
    ],
    'seo' => [
        ['id'=>'basico','label'=>'SEO Básico (Incluido)','price'=>0],
        ['id'=>'intermedio','label'=>'SEO Intermedio','price'=>300],
        ['id'=>'avanzado','label'=>'SEO Avanzado','price'=>950]
    ],
    'branding' => [
        ['id'=>'none','label'=>'No necesito (ya tengo)','price'=>0],
        ['id'=>'logo_basico','label'=>'Logotipo Básico (3 variaciones, 5 iconos)','price'=>350],
        ['id'=>'icono_profesional','label'=>'Icono Profesional (mockups, AI, PSD, PDF, PNG)','price'=>2300]
    ],
    'domain' => [
        ['id'=>'none','label'=>'No necesito (ya tengo)','price'=>0],
        ['id'=>'dominio','label'=>'Dominio (.com)','price'=>250]
    ],
    'hosting' => [
        ['id'=>'none','label'=>'No necesito (ya tengo)','price'=>0],
        ['id'=>'compartido','label'=>'Hosting Compartido (5k–10k visitas)','price'=>250],
        ['id'=>'profesional','label'=>'Hosting Profesional (15k–25k visitas)','price'=>800],
        ['id'=>'avanzado','label'=>'Hosting Avanzado (25k–50k visitas)','price'=>1300]
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
    <h1>Detalles de tu Cotización</h1>
    <form method="post" action="">

      <!-- Diseño -->
      <div class="section">
        <h2>Diseño</h2>
        <?php foreach ($options['design'] as $opt): ?>
          <label class="radio-option">
            <input type="radio" name="design" value="<?= $opt['id']; ?>" required>
            <span><?= $opt['label']; ?><?php if($opt['price']>0) echo " (Q".number_format($opt['price'],2).")"; ?></span>
          </label>
        <?php endforeach; ?>
      </div>

      <!-- Páginas adicionales -->
      <div class="section">
        <h2>Diseño y Creación de Páginas Adicionales</h2>
        <?php foreach ($options['extras'] as $opt): ?>
          <label class="checkbox-option">
            <input type="checkbox" name="extras[]" value="<?= $opt['id']; ?>">
            <span><?= $opt['label']; ?> (Q<?= number_format($opt['price'],2); ?>)</span>
          </label><br>
        <?php endforeach; ?>
        <label class="form-group">
          <span>Otras páginas personalizadas (Q<?= Q_PER_EXTRA_PAGE; ?> p/u):</span>
          <input type="number" name="extra_pages" min="0" value="0">
        </label>
      </div>

      <!-- Productos para Ecommerce -->
      <?php if ($_SESSION['site_type'] === 'ecommerce'): ?>
      <div class="section">
        <h2>Productos para Ecommerce</h2>
        <?php foreach ($options['products_range'] as $opt): ?>
          <label class="radio-option">
            <input type="radio" name="products_range" value="<?= $opt['id']; ?>" required>
            <span><?= $opt['label']; ?><?php if($opt['price']>0) echo " (Q".number_format($opt['price'],2).")"; ?></span>
          </label>
        <?php endforeach; ?>
        <label class="form-group">
          <span>Más productos (Q<?= Q_PER_EXTRA_PRODUCTS; ?> x 50):</span>
          <input type="number" name="extra_products" step="50" min="0" value="0">
        </label>
      </div>
      <?php endif; ?>

      <!-- SEO -->
      <div class="section">
        <h2>SEO</h2>
        <?php foreach ($options['seo'] as $opt): ?>
          <label class="radio-option">
            <input type="radio" name="seo" value="<?= $opt['id']; ?>" <?php echo $opt['id']==='basico'?'checked':''; ?>>
            <span><?= $opt['label']; ?><?php if($opt['price']>0) echo " (Q".number_format($opt['price'],2).")"; ?></span>
          </label>
        <?php endforeach; ?>
      </div>

      <!-- Branding -->
      <div class="section">
        <h2>Branding</h2>
        <?php foreach ($options['branding'] as $opt): ?>
          <label class="radio-option">
            <input type="radio" name="branding" value="<?= $opt['id']; ?>" <?php echo $opt['id']==='none'?'checked':''; ?>>
            <span><?= $opt['label']; ?><?php if($opt['price']>0) echo " (Q".number_format($opt['price'],2).")"; ?></span>
          </label>
        <?php endforeach; ?>
      </div>

      <!-- Dominio -->
      <div class="section">
        <h2>Dominio</h2>
        <?php foreach ($options['domain'] as $opt): ?>
          <label class="radio-option">
            <input type="radio" name="domain" value="<?= $opt['id']; ?>" <?php echo $opt['id']==='none'?'checked':''; ?>>
            <span><?= $opt['label']; ?><?php if($opt['price']>0) echo " (Q".number_format($opt['price'],2).")"; ?></span>
          </label>
        <?php endforeach; ?>
      </div>

      <!-- Hosting -->
      <div class="section">
        <h2>Hosting</h2>
        <?php foreach ($options['hosting'] as $opt): ?>
          <label class="radio-option">
            <input type="radio" name="hosting" value="<?= $opt['id']; ?>" <?php echo $opt['id']==='none'?'checked':''; ?>>
            <span><?= $opt['label']; ?><?php if($opt['price']>0) echo " (Q".number_format($opt['price'],2).")"; ?></span>
          </label>
        <?php endforeach; ?>
      </div>

      <button type="submit" class="btn">Generar Cotización</button>
    </form>
  </div>
</body>
</html>