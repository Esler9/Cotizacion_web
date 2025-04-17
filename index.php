<?php
session_start();
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['site_type'])) {
  $_SESSION['site_type'] = $_POST['site_type'];
  header('Location: options.php');
  exit;
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Cotizador</title></head><body>
  <h1>Cotizador Web</h1>
  <form method="post">
    <label><input type="radio" name="site_type" value="static" required> Página Estática (Q899)</label><br>
    <label><input type="radio" name="site_type" value="store"> Tienda en Línea (Q1499)</label><br><br>
    <button type="submit">Siguiente</button>
  </form>
</body></html>
