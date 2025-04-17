<?php
session_start();
// Si no hay selección previa, regresar a index.php
if (!isset($_SESSION['site_type'])) {
    header('Location: index.php');
    exit;
}

// Opciones y precios
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
    <form method="post" action="">
      <?php foreach ($options as $group => $items): ?>
        <fieldset>
          <legend><?php echo ucfirst($group); ?></legend>
          <?php foreach ($items as $opt): ?>
            <label>
              <input type="checkbox" name="<?php echo $group; ?>[]" value="<?php echo $opt['id']; ?>">
              <?php echo $opt['label']; ?><?php if ($opt['price']>0) echo " (Q".number_format($opt['price'],2).")"; ?>
            </label><br>
          <?php endforeach; ?>
        </fieldset>
        <br>
      <?php endforeach; ?>
      <div class="form-group">
        <label for="extra_pages">Páginas adicionales (Q100 c/u):</label>
        <input type="number" id="extra_pages" name="extra_pages" min="0" value="0">
      </div>
      <div class="form-group">
        <label for="products">Productos (50 incluidos, +50 = Q100):</label>
        <input type="number" id="products" name="products" step="50" min="50" value="50">
      </div>
      <button type="submit" class="btn">Generar Cotización</button>
    </form>
  </div>
</body>
</html>
```  
