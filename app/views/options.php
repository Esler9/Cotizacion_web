<?php
// app/views/options.php
// Variables disponibles:
//   - $_SESSION['site_type']
//   - $options (array con keys: design, extras, products_range, seo, branding, domain, hosting)
//   - Constantes Q_PER_EXTRA_PAGE y Q_PER_EXTRA_PRODUCTS definidas en el controller
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Paso 2: Detalles de tu Cotización</title>
  <link rel="stylesheet" href="/assets/css/general.css">
  <link rel="stylesheet" href="/assets/css/options.css">
</head>
<body>
  <div class="container">
    <h1>Paso 2: Detalles de tu Cotización</h1>

    <!-- Indicador de pasos -->
    <div class="step-indicator">
      <div class="step">1. Tipo de Sitio</div>
      <div class="step active">2. Detalles</div>
      <div class="step">3. Resultado</div>
    </div>

    <!-- Pestañas -->
    <div class="tabs">
      <button type="button" data-tab="design" class="active">Diseño</button>
      <button type="button" data-tab="extras">Páginas</button>
      <?php if ($_SESSION['site_type'] === 'ecommerce'): ?>
        <button type="button" data-tab="products">Productos</button>
      <?php endif; ?>
      <button type="button" data-tab="seo">SEO</button>
      <button type="button" data-tab="branding">Branding</button>
      <button type="button" data-tab="domain">Dominio</button>
      <button type="button" data-tab="hosting">Hosting</button>
    </div>

    <form method="post" action="/generate_pdf">
      <!-- Diseño -->
      <div id="design" class="tab-content active">
        <div class="options-grid">
          <?php foreach ($options['design'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="design" value="<?= $opt['id'] ?>" required>
              <span class="option-title"><?= htmlspecialchars($opt['label']) ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2) ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Páginas Adicionales -->
      <div id="extras" class="tab-content">
        <div class="options-grid-checkbox">
          <?php foreach ($options['extras'] as $opt): ?>
            <label class="option-card checkbox">
              <input type="checkbox" name="extras[]" value="<?= $opt['id'] ?>">
              <span class="option-title"><?= htmlspecialchars($opt['label']) ?></span>
              <span class="price">Q<?= number_format($opt['price'],2) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
        <div class="form-group">
          <label for="extra_pages">Otras páginas (Q<?= Q_PER_EXTRA_PAGE ?> p/u):</label>
          <input type="number" id="extra_pages" name="extra_pages" min="0" value="0">
        </div>
      </div>

      <!-- Productos (solo Ecommerce) -->
      <?php if ($_SESSION['site_type'] === 'ecommerce'): ?>
      <div id="products" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['products_range'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="products_range" value="<?= $opt['id'] ?>" required>
              <span class="option-title"><?= htmlspecialchars($opt['label']) ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2) ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
        <div class="form-group">
          <label for="extra_products">Más productos (x50 = Q<?= Q_PER_EXTRA_PRODUCTS ?>):</label>
          <input type="number" id="extra_products" name="extra_products" step="50" min="0" value="0">
        </div>
      </div>
      <?php endif; ?>

      <!-- SEO -->
      <div id="seo" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['seo'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="seo" value="<?= $opt['id'] ?>" <?= $opt['id']==='basico'?'checked':'' ?> required>
              <span class="option-title"><?= htmlspecialchars($opt['label']) ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2) ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Branding -->
      <div id="branding" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['branding'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="branding" value="<?= $opt['id'] ?>" <?= $opt['id']==='none'?'checked':'' ?> required>
              <span class="option-title"><?= htmlspecialchars($opt['label']) ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2) ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Dominio -->
      <div id="domain" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['domain'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="domain" value="<?= $opt['id'] ?>" <?= $opt['id']==='none'?'checked':'' ?> required>
              <span class="option-title"><?= htmlspecialchars($opt['label']) ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2) ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Hosting -->
      <div id="hosting" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['hosting'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="hosting" value="<?= $opt['id'] ?>" <?= $opt['id']==='none'?'checked':'' ?> required>
              <span class="option-title"><?= htmlspecialchars($opt['label']) ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2) ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Navegación -->
      <div class="nav-buttons">
        <button type="button" class="btn btn-secondary" id="prevBtn">Anterior</button>
        <button type="button" class="btn" id="nextBtn">Siguiente</button>
      </div>
    </form>
  </div>

  <script src="/assets/js/options.js"></script>
</body>
</html>
