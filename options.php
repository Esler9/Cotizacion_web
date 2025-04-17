<?php
session_start();
if (!isset($_SESSION['site_type'])) {
    header('Location: index.php');
    exit;
}

// Constantes para extras
define('Q_PER_EXTRA_PAGE',     100);
define('Q_PER_EXTRA_PRODUCTS', 100);

// Definición de opciones
$options = [
    'design' => [
        ['id'=>'basica',       'label'=>'Plantilla Básica Incluida',           'price'=>0   ],
        ['id'=>'personalizado','label'=>'Diseño Personalizado',                'price'=>400 ],
        ['id'=>'profesional',  'label'=>'Diseño Profesional de Mercadeo',      'price'=>1500],
    ],
    'extras' => [
        ['id'=>'perfil',       'label'=>'Perfil de Usuario',                   'price'=>200],
        ['id'=>'login',        'label'=>'Login de Usuario',                    'price'=>150],
        ['id'=>'busqueda',     'label'=>'Resultado de Búsqueda',               'price'=>150],
    ],
    'products_range' => [
        ['id'=>'50',        'label'=>'50 Productos Incluidos',    'price'=>0   ],
        ['id'=>'50-200',    'label'=>'50–200 Productos',         'price'=>250 ],
        ['id'=>'200-500',   'label'=>'200–500 Productos',        'price'=>650 ],
        ['id'=>'500-1000',  'label'=>'500–1000 Productos',       'price'=>1450],
    ],
    'seo' => [
        ['id'=>'basico',     'label'=>'SEO Básico (Incluido)',        'price'=>0   ],
        ['id'=>'intermedio', 'label'=>'SEO Intermedio',              'price'=>300 ],
        ['id'=>'avanzado',   'label'=>'SEO Avanzado',                'price'=>950 ],
    ],
    'branding' => [
        ['id'=>'none',              'label'=>'No necesito (ya tengo)',                 'price'=>0   ],
        ['id'=>'logo_basico',       'label'=>'Logotipo Básico (3 variaciones,5 iconos)', 'price'=>350 ],
        ['id'=>'icono_profesional','label'=>'Icono Profesional (AI, PSD, PDF, PNG)',      'price'=>2300],
    ],
    'domain' => [
        ['id'=>'none',    'label'=>'No necesito (ya tengo)','price'=>0  ],
        ['id'=>'dominio', 'label'=>'Dominio (.com)',         'price'=>250],
    ],
    'hosting' => [
        ['id'=>'none',         'label'=>'No necesito (ya tengo)',               'price'=>0   ],
        ['id'=>'compartido',   'label'=>'Hosting Compartido (5k–10k visitas)',  'price'=>250 ],
        ['id'=>'profesional',  'label'=>'Hosting Profesional (15k–25k visitas)','price'=>800 ],
        ['id'=>'avanzado',     'label'=>'Hosting Avanzado (25k–50k visitas)',   'price'=>1300],
    ],
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
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/options.css">
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
    <h1>Detalles de tu Cotización</h1>
    <div class="step-indicator">
      <div class="step">1. Tipo de Sitio</div>
      <div class="step active">2. Detalles</div>
      <div class="step">3. Resultado</div>
    </div>

    <!-- Tabs navigation -->
    <div class="tabs">
      <button type="button" data-tab="design"     class="active">Diseño</button>
      <button type="button" data-tab="extras">Páginas</button>
      <?php if ($_SESSION['site_type']==='ecommerce'): ?>
        <button type="button" data-tab="products_range">Productos</button>
      <?php endif; ?>
      <button type="button" data-tab="seo">SEO</button>
      <button type="button" data-tab="branding">Branding</button>
      <button type="button" data-tab="domain">Dominio</button>
      <button type="button" data-tab="hosting">Hosting</button>
    </div>

    <form method="post">
      <!-- Diseño tab -->
      <div id="design" class="tab-content active">
        <div class="options-grid">
          <?php foreach ($options['design'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="design" value="<?= $opt['id']; ?>" required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?>
                <span class="price">Q<?= number_format($opt['price'],2); ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Páginas tab -->
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

      <!-- Productos tab (solo Ecommerce) -->
      <?php if ($_SESSION['site_type']==='ecommerce'): ?>
      <div id="products_range" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['products_range'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="products_range" value="<?= $opt['id']; ?>" required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?>
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

      <!-- SEO tab -->
      <div id="seo" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['seo'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="seo" value="<?= $opt['id']; ?>" <?= $opt['id']==='basico'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?>
                <span class="price">Q<?= number_format($opt['price'],2); ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Branding tab -->
      <div id="branding" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['branding'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="branding" value="<?= $opt['id']; ?>" <?= $opt['id']==='none'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?>
                <span class="price">Q<?= number_format($opt['price'],2); ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Dominio tab -->
      <div id="domain" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['domain'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="domain" value="<?= $opt['id']; ?>" <?= $opt['id']==='none'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?>
                <span class="price">Q<?= number_format($opt['price'],2); ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Hosting tab -->
      <div id="hosting" class="tab-content">
        <div class="options-grid">
          <?php foreach ($options['hosting'] as $opt): ?>
            <label class="option-card">
              <input type="radio" name="hosting" value="<?= $opt['id']; ?>" <?= $opt['id']==='none'?'checked':''; ?> required>
              <span class="option-title"><?= $opt['label']; ?></span>
              <?php if($opt['price']>0): ?>
                <span class="price">Q<?= number_format($opt['price'],2); ?></span>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="nav-buttons">
        <button type="button" class="btn btn-secondary" id="prevBtn">Anterior</button>
        <button type="submit" class="btn" id="nextBtn">Siguiente</button>
      </div>
    </form>
  </div>

  <script>
    const tabs = document.querySelectorAll('.tabs button');
    const contents = document.querySelectorAll('.tab-content');
    let current = 0;

    tabs.forEach((tab, i) => {
      tab.addEventListener('click', () => activateTab(i));
    });
    document.getElementById('prevBtn').addEventListener('click', () => {
      if (current > 0) activateTab(current - 1);
    });

    function activateTab(index) {
      tabs[current].classList.remove('active');
      contents[current].classList.remove('active');
      current = index;
      tabs[current].classList.add('active');
      contents[current].classList.add('active');
    }
  </script>
</body>
</html>
