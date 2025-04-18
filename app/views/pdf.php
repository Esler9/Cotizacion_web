<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paso 4: Resumen de Propuesta Comercial</title>
  <link rel="stylesheet" href="/assets/css/general.css?v=1.0">
  <link rel="stylesheet" href="/assets/css/index.css?v=1.0">
  <link rel="stylesheet" href="/assets/css/pdf.css?v=1.0">
  <link rel="stylesheet" href="/assets/css/preview.css?v=1.0">
</head>
<body>
  <div class="container">
    <h1>Paso 4: Resumen de Propuesta Comercial</h1>
    <div class="step-indicator">
      <div class="step">1. Tipo de Sitio</div>
      <div class="step">2. Detalles</div>
      <div class="step">3. Información del Cliente</div>
      <div class="step active">4. Resultado</div>
    </div>
    <?php $total = array_sum(array_column($items, 'price')); ?>
    <table class="table">
      <thead>
        <tr>
          <th>Servicio</th>
          <th>Precio (Q)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $it): ?>
        <tr>
          <td><?= htmlspecialchars($it['desc'], ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= number_format($it['price'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="total"><strong>Inversión Total (IVA incluido):</strong> Q<?= number_format($total, 2); ?></div>
    <form method="post" action="/generate_pdf">
      <button type="submit" class="btn">Descargar PDF</button>
    </form>
  </div>
</body>
</html>
