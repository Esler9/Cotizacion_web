<?php
session_start();
if (!isset($_SESSION['site_type'])) {
    header('Location: index.php');
    exit;
}
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
        ['id'=>'50-200','label'=>'50–200 Productos','price'=>250],
        ['id'=>'200-500','label'=>'200–500 Productos','price'=>650],
        ['id'=>'500-1000','label'=>'500–1000 Productos','price'=>1450]
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
  <title>Detalles de Cotización – Paso 2</title>
  <link rel="stylesheet" href="general.css">
  <link rel="stylesheet" href="options.css">
</head>
<body>
  <div class="container">
    <h1>Detalles de tu Cotización</h1>
    <div class="step-indicator">
      <div class="step">1. Tipo de Sitio</div>
      <div class="step active">2. Detalles</div>
      <div class="step">3. Resultado</div>
    </div>
    <form method="post">

      <!-- Diseño -->
      <section class="section">
        <h2>Diseño</h2>
        <div class="options-grid">
          <?php foreach ($options['design'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="design" value="<?= $opt['id']; ?>" required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?><span class="price">Q<?= number_format($opt['price'],2); ?></span><?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- Páginas Adicionales -->
      <section class="section">
        <h2>Páginas Adicionales</h2>
        <div class="options-grid-checkbox">
          <?php foreach ($options['extras'] as $opt): ?>
            <label class="option-card checkbox">
              <input type="checkbox" name="extras[]" value="<?= $opt['id']; ?>">
              <span class="option-title"><?= $opt['label']; ?></span>
              <span class="price">Q<?= number_format($opt['price'],2); ?></span>
            </label>
          <?php endforeach; ?>
        </div>
        <div class="form-group">
          <label for="extra_pages">Otras páginas (Q<?= Q_PER_EXTRA_PAGE; ?> p/u):</label>
          <input type="number" id="extra_pages" name="extra_pages" min="0" value="0">
        </div>
      </section>

      <!-- Productos (solo Ecommerce) -->
      <?php if ($_SESSION['site_type'] === 'ecommerce'): ?>
      <section class="section">
        <h2>Productos para Ecommerce</h2>
        <div class="options-grid">
          <?php foreach ($options['products_range'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="products_range" value="<?= $opt['id']; ?>" required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?><span class="price">Q<?= number_format($opt['price'],2); ?></span><?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
        <div class="form-group">
          <label for="extra_products">Más productos (x50 = Q<?= Q_PER_EXTRA_PRODUCTS; ?>):</label>
          <input type="number" id="extra_products" name="extra_products" step="50" min="0" value="0">
        </div>
      </section>
      <?php endif; ?>

      <!-- SEO -->
      <section class="section">
        <h2>SEO</h2>
        <div class="options-grid">
          <?php foreach ($options['seo'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="seo" value="<?= $opt['id']; ?>" <?= $opt['id']==='basico'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?><span class="price">Q<?= number_format($opt['price'],2); ?></span><?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- Branding -->
      <section class="section">
        <h2>Branding</h2>
        <div class="options-grid">
          <?php foreach ($options['branding'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="branding" value="<?= $opt['id']; ?>" <?= $opt['id']==='none'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?><span class="price">Q<?= number_format($opt['price'],2); ?></span><?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- Dominio -->
      <section class="section">
        <h2>Dominio</h2>
        <div class="options-grid">
          <?php foreach ($options['domain'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="domain" value="<?= $opt['id']; ?>" <?= $opt['id']==='none'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?><span class="price">Q<?= number_format($opt['price'],2); ?></span><?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- Hosting -->
      <section class="section">
        <h2>Hosting</h2>
        <div class="options-grid">
          <?php foreach ($options['hosting'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="hosting" value="<?= $opt['id']; ?>" <?= $opt['id']==='none'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?><span class="price">Q<?= number_format($opt['price'],2); ?></span><?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </section>

      <button type="submit" class="btn">Generar Cotización</button>
    </form>
  </div>
</body>
</html>
