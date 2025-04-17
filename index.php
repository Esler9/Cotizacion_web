<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['site_type'])) {
    $_SESSION['site_type'] = $_POST['site_type'];
    header('Location: options.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cotizador Web</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>Cotizador de Sitio Web</h1>
    <div class="step-indicator">
      <div class="step active">1. Tipo de Sitio</div>
      <div class="step">2. Detalles</div>
      <div class="step">3. Resultado</div>
    </div>
    <form method="post">
      <div class="options-grid">
        <input type="radio" id="opt-informativa" name="site_type" value="informativa" hidden required>
        <label for="opt-informativa" class="option-card">
          <span class="option-title">Página Informativa</span>
          <span class="option-desc">3 páginas: Home, Contacto, Servicios</span>
          <span class="price">Q400.00</span>
        </label>

        <input type="radio" id="opt-ecommerce" name="site_type" value="ecommerce" hidden>
        <label for="opt-ecommerce" class="option-card">
          <span class="option-title">Página Ecommerce</span>
          <span class="option-desc">7 páginas: Home, Contacto, Tienda, Producto, Categoría, Carrito, Checkout</span>
          <span class="price">Q800.00</span>
        </label>

        <input type="radio" id="opt-scalable" name="site_type" value="scalable" hidden>
        <label for="opt-scalable" class="option-card">
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
