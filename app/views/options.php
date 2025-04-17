<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Paso 2: Detalles</title>
  <link rel="stylesheet" href="/assets/css/general.css">
  <link rel="stylesheet" href="/assets/css/options.css"> 
  <style>
    /* Wizard tabs */
    .tabs { display: flex; border-bottom:2px solid #eee; margin-bottom:var(--spacing); }
    .tabs button {
      flex:1; background:none; border:none; padding:var(--spacing) 0;
      cursor:pointer; font-weight:500; transition:background .2s;
    }
    .tabs button.active { border-bottom:3px solid var(--primary); color:var(--primary); }
    .tabs button:hover { background:rgba(52,152,219,0.05); }
    .tab-content { display:none; }
    .tab-content.active { display:block; }
    .nav-buttons { display:flex; justify-content:space-between; margin-top:var(--spacing); }
    .btn-secondary { background:#ccc; color:#333; }
    .btn-secondary:hover { background:#bbb; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Paso 2: Detalles</h1>
    <div class="step-indicator">
      <div class="step">1. Tipo de Sitio</div>
      <div class="step active">2. Detalles</div>
      <div class="step">3. Resultado</div>
    </div>

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

    <form method="post" action="">
      <!-- Diseño -->
      <div id="design" class="tab-content active">
        <div class="options-grid">
          <?php if (isset($options['design'])): ?>
            <?php foreach ($options['design'] as $opt): ?>
              <label class="option-card">
                <input type="radio" name="design" value="<?= $opt['id']; ?>" required>
                <span class="option-title"><?= $opt['label']; ?></span>
                <?php if ($opt['price'] > 0): ?>
                  <span class="price">Q<?= number_format($opt['price'],2); ?></span>
                <?php endif; ?>
              </label>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <!-- Páginas adicionales -->
      <div id="extras" class="tab-content">
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
      </div>

      <!-- Productos (solo ecommerce) -->
      <?php if ($_SESSION['site_type'] === 'ecommerce'): ?>
      <div id="products" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['products_range'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="products_range" value="<?= $opt['id']; ?>" required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2); ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
        <div class="form-group">
          <label for="extra_products">Más productos (x50 = Q<?= Q_PER_EXTRA_PRODUCTS; ?>):</label>
          <input type="number" id="extra_products" name="extra_products" step="50" min="0" value="0">
        </div>
      </div>
      <?php endif; ?>

      <!-- SEO -->
      <div id="seo" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['seo'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="seo" value="<?= $opt['id']; ?>" <?= $opt['id']==='basico'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2); ?></span>
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
              <input type="radio" name="branding" value="<?= $opt['id']; ?>" <?= $opt['id']==='none'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2); ?></span>
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
              <input type="radio" name="domain" value="<?= $opt['id']; ?>" <?= $opt['id']==='none'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2); ?></span>
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
              <input type="radio" name="hosting" value="<?= $opt['id']; ?>" <?= $opt['id']==='none'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2); ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="nav-buttons">
        <button type="button" class="btn btn-secondary" id="prevBtn">Anterior</button>
        <button type="button" class="btn" id="nextBtn">Siguiente</button>
      </div>
    </form>
  </div>

  <script src="/public/assets/js/options.js"></script>
</body>
</html>
