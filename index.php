<?php
session_start();
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['site_type'])
) {
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
    <form method="post" action="">
      <label class="radio-option">
        <input type="radio" name="site_type" value="informativa" required>
        <span>Página Informativa Q400.00: 3 páginas (Home, Contacto, Servicios)</span>
      </label>
      <label class="radio-option">
        <input type="radio" name="site_type" value="ecommerce">
        <span>Página Ecommerce Q800.00: 7 páginas (Home, Contacto, Tienda, Producto, Categoría, Carrito, Checkout)</span>
      </label>
      <label class="radio-option">
        <input type="radio" name="site_type" value="scalable">
        <span>Sitio Web Escalable y Personalizado (Laravel + Vue.js) Desde Q3,999</span>
      </label>
      <button type="submit" class="btn">Siguiente</button>
    </form>
  </div>
</body>
</html>