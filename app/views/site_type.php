<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
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

    <form method="post" action="/">
      <div class="options-grid">
        <input type="radio" id="informativa" name="site_type" value="informativa" hidden required>
        <label for="informativa" class="option-card">
          <h3>Página Informativa</h3>
          <p>3 páginas: Home, Contacto, Servicios</p>
          <div class="price">Q899.00</div>
        </label>

        <input type="radio" id="ecommerce" name="site_type" value="ecommerce" hidden>
        <label for="ecommerce" class="option-card">
          <h3>Página Ecommerce</h3>
          <p>7 páginas: Home, Contacto, Tienda, Producto, Categoría, Carrito, Checkout</p>
          <div class="price">Q1499.00</div>
        </label>

        <input type="radio" id="scalable" name="site_type" value="scalable" hidden>
        <label for="scalable" class="option-card">
          <h3>Sitio Web Escalable</h3>
          <p>Laravel + Vue.js desde Q3,999</p>
          <div class="price">Desde Q3,999</div>
        </label>
      </div>

      <button type="submit" class="btn">Siguiente</button>
    </form>
  </div>
</body>
</html>
