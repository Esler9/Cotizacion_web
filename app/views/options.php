<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Paso 2: Detalles</title>
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

    <form method="post" action="/summary">
      <div class="tabs">
        <button type="button" data-tab="design" class="active">Diseño</button>
        <button type="button" data-tab="extras">Páginas</button>
        <?php if ($_SESSION['site_type']==='ecommerce'): ?>
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
              <?php if ($opt['price']>0): ?>
                <span class="price">Q<?= number_format($opt['price'],2) ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Repite la misma lógica para `extras`, `products`, etc., siempre con:
           <input hidden id="..."><label for="...">...</label>
      -->

      <div class="nav-buttons">
        <button type="button" class="btn btn-secondary" id="prevBtn">Anterior</button>
        <button type="button" class="btn" id="nextBtn">Siguiente</button>
      </div>
    </form>
  </div>
  <script src="/assets/js/options.js"></script>
</body>
</html>
