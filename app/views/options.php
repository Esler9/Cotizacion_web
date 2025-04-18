<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paso 2: Detalles de tu Cotización</title>
  <link rel="stylesheet" href="/assets/css/general.css?v=1.0">
  <link rel="stylesheet" href="/assets/css/index.css?v=1.0">
  <link rel="stylesheet" href="/assets/css/options.css?v=1.0">
</head>
<body>
  <div class="container">
    <h1>Paso 2: Detalles de tu Cotización</h1>
    <div class="step-indicator">
      <div class="step">1. Tipo de Sitio</div>
      <div class="step active">2. Detalles</div>
      <div class="step">3. Información de Cliente</div>
      <div class="step">4. Resultado</div>
    </div>
    <form method="post" action="/options">
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
            <input
              type="radio"
              id="design-<?= $opt['id']; ?>"
              name="design"
              value="<?= $opt['id']; ?>"
              hidden
              <?= $opt['id'] === 'basica' ? 'checked' : ''; ?>
              required
            >
            <label for="design-<?= $opt['id']; ?>" class="option-card">
              <h2 class="option-title"><?= htmlspecialchars($opt['label']); ?></h2>
              <p class="option-desc">
                <?php
                switch ($opt['id']) {
                  case 'basica':
                    echo 'Diseño con plantilla profesional, ideal para arrancar con rapidez y bajo inversión.';
                    break;
                  case 'personalizado':
                    echo 'Diseño 100 % personalizado que refleja tu identidad de marca y garantiza diferenciación.';
                    break;
                  case 'profesional':
                    echo 'Diseño profesional optimizado para marketing digital y conversión de usuarios.';
                    break;
                }
                ?>
              </p>
              <?php if ($opt['price'] > 0): ?>
                <div class="price">Q<?= number_format($opt['price'], 2); ?></div>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Páginas Extras -->
      <div id="extras" class="tab-content">
        <div class="options-grid-checkbox">
          <?php foreach ($options['extras'] as $opt): ?>
            <input
              type="checkbox"
              id="extra-<?= $opt['id']; ?>"
              name="extras[]"
              value="<?= $opt['id']; ?>"
              hidden
            >
            <label for="extra-<?= $opt['id']; ?>" class="option-card checkbox">
              <h2 class="option-title"><?= htmlspecialchars($opt['label']); ?></h2>
              <p class="option-desc">
                <?php
                switch ($opt['id']) {
                  case 'perfil':
                    echo 'Página de perfil personalizada para presentar a tus clientes de forma clara.';
                    break;
                  case 'login':
                    echo 'Formulario de acceso seguro con validación avanzada y UX amigable.';
                    break;
                  case 'busqueda':
                    echo 'Motor de búsqueda dinámico con filtros personalizados y resultados en tiempo real.';
                    break;
                }
                ?>
              </p>
              <div class="price">Q<?= number_format($opt['price'], 2); ?></div>
            </label>
          <?php endforeach; ?>
        </div>
        <div class="form-group">
          <label for="extra_pages">Otras páginas (Q<?= Q_PER_EXTRA_PAGE; ?> p/u):</label>
          <input type="number" id="extra_pages" name="extra_pages" min="0" value="0">
        </div>
      </div>

      <!-- Productos (solo Ecommerce) -->
      <?php if ($_SESSION['site_type'] === 'ecommerce'): ?>
      <div id="products" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['products_range'] as $opt): ?>
            <input
              type="radio"
              id="prod-<?= $opt['id']; ?>"
              name="products_range"
              value="<?= $opt['id']; ?>"
              hidden
              <?= $opt['id'] === '50' ? 'checked' : ''; ?>
              required
            >
            <label for="prod-<?= $opt['id']; ?>" class="option-card">
              <h2 class="option-title"><?= htmlspecialchars($opt['label']); ?></h2>
              <p class="option-desc">
                <?php
                switch ($opt['id']) {
                  case '50':
                    echo 'Catálogo inicial de hasta 50 productos listos para publicar.';
                    break;
                  case '50-200':
                    echo 'Catálogo de 50–200 productos con carga y gestión completas.';
                    break;
                  case '200-500':
                    echo 'Catálogo de 200–500 productos con control de inventario y categorías.';
                    break;
                  case '500-1000':
                    echo 'Catálogo de hasta 1 000 productos con optimización de rendimiento.';
                    break;
                }
                ?>
              </p>
              <?php if ($opt['price'] > 0): ?>
                <div class="price">Q<?= number_format($opt['price'], 2); ?></div>
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
            <input
              type="radio"
              id="seo-<?= $opt['id']; ?>"
              name="seo"
              value="<?= $opt['id']; ?>"
              hidden
              <?= $opt['id'] === 'basico' ? 'checked' : ''; ?>
              required
            >
            <label for="seo-<?= $opt['id']; ?>" class="option-card">
              <h2 class="option-title"><?= htmlspecialchars($opt['label']); ?></h2>
              <p class="option-desc">
                <?php
                switch ($opt['id']) {
                  case 'basico':
                    echo 'Optimización básica: meta­títulos, meta­descripciones y URLs amigables para buscadores.';
                    break;
                  case 'intermedio':
                    echo 'Añadido a básico: optimización de imágenes, encabezados semánticos y velocidad de carga.';
                    break;
                  case 'avanzado':
                    echo 'Paquete completo: sitemap XML, robots.txt, datos estructurados (JSON‑LD) y auditoría on‑page.';
                    break;
                }
                ?>
              </p>
              <?php if ($opt['price'] > 0): ?>
                <div class="price">Q<?= number_format($opt['price'], 2); ?></div>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Branding -->
      <div id="branding" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['branding'] as $opt): ?>
            <input
              type="radio"
              id="brand-<?= $opt['id']; ?>"
              name="branding"
              value="<?= $opt['id']; ?>"
              hidden
              <?= $opt['id'] === 'none' ? 'checked' : ''; ?>
              required
            >
            <label for="brand-<?= $opt['id']; ?>" class="option-card">
              <h2 class="option-title"><?= htmlspecialchars($opt['label']); ?></h2>
              <p class="option-desc">
                <?php
                switch ($opt['id']) {
                  case 'none':
                    echo 'No requieres branding; usaremos tu imagen corporativa existente.';
                    break;
                  case 'logo_basico':
                    echo 'Diseño de logo básico: 3 propuestas y entrega de 5 iconos en múltiples formatos.';
                    break;
                  case 'icono_profesional':
                    echo 'Branding profesional: logo vectorial + manual de uso, con archivos AI, PSD, PDF y PNG.';
                    break;
                }
                ?>
              </p>
              <?php if ($opt['price'] > 0): ?>
                <div class="price">Q<?= number_format($opt['price'], 2); ?></div>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Dominio -->
      <div id="domain" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['domain'] as $opt): ?>
            <input
              type="radio"
              id="dom-<?= $opt['id']; ?>"
              name="domain"
              value="<?= $opt['id']; ?>"
              hidden
              <?= $opt['id'] === 'none' ? 'checked' : ''; ?>
              required
            >
            <label for="dom-<?= $opt['id']; ?>" class="option-card">
              <h2 class="option-title"><?= htmlspecialchars($opt['label']); ?></h2>
              <p class="option-desc">
                <?= $opt['id'] === 'dominio'
                    ? 'Registro y configuración de dominio .com por 1 año, DNS y SSL incluidos.'
                    : 'No incluye dominio; se utilizará tu dominio actual.'; ?>
              </p>
              <?php if ($opt['price'] > 0): ?>
                <div class="price">Q<?= number_format($opt['price'], 2); ?></div>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Hosting -->
      <div id="hosting" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['hosting'] as $opt): ?>
            <input
              type="radio"
              id="host-<?= $opt['id']; ?>"
              name="hosting"
              value="<?= $opt['id']; ?>"
              hidden
              <?= $opt['id'] === 'none' ? 'checked' : ''; ?>
              required
            >
            <label for="host-<?= $opt['id']; ?>" class="option-card">
              <h2 class="option-title"><?= htmlspecialchars($opt['label']); ?></h2>
              <p class="option-desc">
                <?php
                switch ($opt['id']) {
                  case 'compartido':
                    echo 'Hosting compartido para hasta 10 000 visitas mensuales con SSL gratis y backups semanales.';
                    break;
                  case 'profesional':
                    echo 'Hosting profesional para hasta 25 000 visitas mensuales, optimizado en velocidad y seguridad.';
                    break;
                  case 'avanzado':
                    echo 'Hosting avanzado: hasta 50 000 visitas mensuales, con CDN integrado y monitoreo 24/7.';
                    break;
                  default:
                    echo 'No incluye hosting; se utilizará la infraestructura que ya poseas.';
                    break;
                }
                ?>
              </p>
              <?php if ($opt['price'] > 0): ?>
                <div class="price">Q<?= number_format($opt['price'], 2); ?></div>
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
  <script src="/assets/js/options.js"></script>
</body>
</html>
