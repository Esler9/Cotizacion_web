<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Paso 1: Tipo de Sitio</title>
  <link rel="stylesheet" href="/assets/css/general.css">
  <link rel="stylesheet" href="/assets/css/index.css">
</head>
<body>
  <div class="container">
    <h1>Paso 1: Tipo de Sitio</h1>
    <div class="step-indicator">
      <div class="step active">1. Tipo de Sitio</div>
      <div class="step">2. Detalles</div>
      <div class="step">3. Resultado</div>
    </div>
    <form method="post" action="">
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
            <p>Laravel + Vue.js desde Q3,999</p>
          </div>
          <div class="price">Desde Q3,999</div>
        </label>
      </div>
      <button type="submit" class="btn">Siguiente</button>
    </form>
  </div>
</body>
</html>
