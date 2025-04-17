<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['site_type'])) {
    $_SESSION['site_type'] = $_POST['site_type'];
    header('Location: options.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cotizador Web – Paso 1</title>
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
  <div class="container">
    <h1>Cotizador de Sitio Web</h1>
    <!-- Indicador de pasos -->
    <div class="step-indicator">
      <div class="step active">1. Tipo de Sitio</div>
      <div class="step">2. Detalles</div>
      <div class="step">3. Resultado</div>
    </div>

    <form method="post">
      <!-- Grid de opciones -->
      <div class="options-grid">
        <label class="option-card">
          <input type="radio" name="site_type" value="informativa" required>
          <div class="option-content">
            <h3>Página Informativa</h3>
            <p>3 páginas: Home, Contacto, Servicios</p>
          </div>
          <div class="price">Q400.00</div>
        </label>

        <label class="option-card">
          <input type="radio" name="site_type" value="ecommerce">
          <div class="option-content">
            <h3>Página Ecommerce</h3>
            <p>7 páginas: Home, Contacto, Tienda, Producto, Categoría, Carrito, Checkout</p>
          </div>
          <div class="price">Q800.00</div>
        </label>

        <label class="option-card">
          <input type="radio" name="site_type" value="scalable">
          <div class="option-content">
            <h3>Sitio Web Escalable</h3>
            <p>Laravel + Vue.js desde Q3,999</p>
          </div>
          <div class="price">Desde Q3,999</div>
        </label>
      </div>

      <button type="submit" class="btn">Siguiente</button>
    </form>
  </div>
</body>
</html>
