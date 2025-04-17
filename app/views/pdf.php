<!-- app/views/pdf.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Paso 3: Resumen de Cotización</title>
  <link rel="stylesheet" href="/css/general.css">
  <link rel="stylesheet" href="/css/pdf.css">
</head>
<body>
  <div class="container">
    <h1>Paso 3: Resumen de Cotización</h1>
    <div class="step-indicator">
      <div class="step">1. Tipo de Sitio</div>
      <div class="step">2. Detalles</div>
      <div class="step active">3. Resultado</div>
    </div>

    <?php
      use App\models\Quote;

      // Calcula items y total
      $quote = new Quote();
      $items = $quote->calculate($_SESSION['site_type'], $_SESSION['options']);
      $total = array_sum(array_column($items, 'price'));
    ?>

    <table class="table">
      <thead>
        <tr>
          <th>Concepto</th>
          <th>Precio (Q)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $it): ?>
        <tr>
          <td><?= htmlspecialchars($it['desc']) ?></td>
          <td><?= number_format($it['price'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="total">Total: Q<?= number_format($total, 2) ?></div>

    <form method="post" action="/generate_pdf">
      <button type="submit" class="btn">Descargar PDF</button>
    </form>
  </div>
</body>
</html>
