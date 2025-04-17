```php
<?php
// index.php
// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['site_type'])) {
        $_SESSION['site_type'] = $_POST['site_type'];
        header('Location: options.php');
        exit;
    } else {
        $error = 'Por favor selecciona un tipo de sitio.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cotizador Web – Paso 1</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .error {
      background: #ffe5e5;
      color: #d8000c;
      padding: 10px;
      border-radius: 4px;
      margin-bottom: 16px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Cotizador de Sitio Web</h1>
    <?php if ($error): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <div class="options-grid">
        <input type="radio" id="informativa" name="site_type" value="informativa" hidden
          <?= (isset($_POST['site_type']) && $_POST['site_type']==='informativa') ? 'checked' : '' ?> required>
        <label for="informativa" class="option-card">
          <span class="option-title">Página Informativa</span>
          <span class="option-desc">3 páginas: Home, Contacto, Servicios</span>
          <span class="price">Q400.00</span>
        </label>

        <input type="radio" id="ecommerce" name="site_type" value="ecommerce" hidden
          <?= (isset($_POST['site_type']) && $_POST['site_type']==='ecommerce') ? 'checked' : '' ?>>
        <label for="ecommerce" class="option-card">
          <span class="option-title">Página Ecommerce</span>
          <span class="option-desc">7 páginas: Home, Contacto, Tienda, Producto, Categoría, Carrito, Checkout</span>
          <span class="price">Q800.00</span>
        </label>

        <input type="radio" id="scalable" name="site_type" value="scalable" hidden
          <?= (isset($_POST['site_type']) && $_POST['site_type']==='scalable') ? 'checked' : '' ?>>
        <label for="scalable" class="option-card">
          <span class="option-title">Sitio Web Escalable y Personalizado</span>
          <span class="option-desc">Laravel + Vue.js desde Q3,999</span>
          <span class="price">Desde Q3,999</span>
        </label>
      </div>

      <button type="submit" class="btn">Siguiente</button>
    </form>
  </div>
</body>
</html>
```