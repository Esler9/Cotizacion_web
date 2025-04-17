
<?php
session_start();
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['site_type'])
) {
    // Guardar selección y redirigir a options.php
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
      <label>
        <input type="radio" name="site_type" value="informativa" required>
        Página Informativa
      </label><br><br>
      <label>
        <input type="radio" name="site_type" value="ecommerce">
        Página Ecommerce
      </label><br><br>
      <button type="submit" class="btn">Siguiente</button>
    </form>
  </div>
</body>
</html>