<?php
// index.php - Formulario inicial para cotizador
session_start();
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['site_type'])
) {
    // Guardar selección y redirigir a siguiente paso
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
    <style>
        body { margin:0; font-family:Arial,sans-serif; background:#f9f9f9; color:#333; }
        .container { max-width:600px; margin:40px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        h1 { text-align:center; margin-bottom:20px; font-size:1.5em; }
        .btn { display:block; width:100%; padding:10px; background:#3498DB; color:#fff; border:none; border-radius:4px; font-size:1em; cursor:pointer; }
        .btn:hover { background:#2980b9; }
    </style>
</head>
<body>
<div class="container">
    <h1>Cotizador de Sitio Web</h1>
    <form method="post">
        <label><input type="radio" name="site_type" value="static" required> Página Estática (Q899)</label><br><br>
        <label><input type="radio" name="site_type" value="store"> Tienda en Línea (Q1499)</label><br><br>
        <button type="submit" class="btn">Siguiente</button>
    </form>
</div>
</body>
</html>