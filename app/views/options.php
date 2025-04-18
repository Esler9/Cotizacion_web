<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paso 2: Detalles de tu Cotización</title>
  <link rel="stylesheet" href="/assets/css/general.css">
  <link rel="stylesheet" href="/assets/css/options.css">
</head>
<body>
  <div class="container">
    <h1>Paso 2: Detalles de tu Cotización</h1>
    <div class="step-indicator">
      <div class="step">1. Tipo de Sitio</div>
      <div class="step active">2. Detalles</div>
      <div class="step">3. Resultado</div>
    </div>

    <form method="post" action="/options">
      <!-- Navegación de pestañas -->
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

      <!-- Diseño -->
      <div id="design" class="tab-content active">
        <div class="options-grid">
          <?php foreach ($options['design'] as $opt): ?>
            <input type="radio"
                   id="design-<?= $opt['id'] ?>"
                   name="design"
                   value="<?= $opt['id'] ?>"
                   hidden required>
            <label for="design-<?= $opt['id'] ?>" class="option-card">
              <span class="option-title"><?= htmlspecialchars($opt['label']) ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2) ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Páginas Extras -->
      <div id="extras" class="tab-content">
        <div class="options-grid-checkbox">
          <?php foreach ($options['extras'] as $opt): ?>
            <input type="checkbox"
                   id="extra-<?= $opt['id'] ?>"
                   name="extras[]"
                   value="<?= $opt['id'] ?>"
                   hidden>
            <label for="extra-<?= $opt['id'] ?>" class="option-card checkbox">
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
            <input type="radio"
                   id="prod-<?= $opt['id'] ?>"
                   name="products_range"
                   value="<?= $opt['id'] ?>"
                   hidden required>
            <label for="prod-<?= $opt['id'] ?>" class="option-card">
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
            <input type="radio"
                   id="seo-<?= $opt['id'] ?>"
                   name="seo"
                   value="<?= $opt['id'] ?>"
                   hidden <?= $opt['id']==='basico'?'checked':'' ?> required>
            <label for="seo-<?= $opt['id'] ?>" class="option-card">
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
            <input type="radio"
                   id="brand-<?= $opt['id'] ?>"
                   name="branding"
                   value="<?= $opt['id'] ?>"
                   hidden <?= $opt['id']==='none'?'checked':'' ?> required>
            <label for="brand-<?= $opt['id'] ?>" class="option-card">
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
            <input type="radio"
                   id="dom-<?= $opt['id'] ?>"
                   name="domain"
                   value="<?= $opt['id'] ?>"
                   hidden <?= $opt['id']==='none'?'checked':'' ?> required>
            <label for="dom-<?= $opt['id'] ?>" class="option-card">
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
            <input type="radio"
                   id="host-<?= $opt['id'] ?>"
                   name="hosting"
                   value="<?= $opt['id'] ?>"
                   hidden <?= $opt['id']==='none'?'checked':'' ?> required>
            <label for="host-<?= $opt['id'] ?>" class="option-card">
              <span class="option-title"><?= htmlspecialchars($opt['label']) ?></span>
              <?php if ($opt['price'] > 0): ?>
                <span class="price">Q<?= number_format($opt['price'],2) ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Botones Navegación -->
      <div class="nav-buttons">
        <button type="button" class="btn btn-secondary" id="prevBtn">Anterior</button>
        <button type="button" class="btn" id="nextBtn">Siguiente</button>
      </div>
    </form>
  </div>

  <script src="/assets/js/options.js"></script>
</body>
</html>
