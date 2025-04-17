<?php
session_start();
if (!isset($_SESSION['site_type'])) {
  header('Location:index.php'); exit;
}
$extras = [
  'seo'     => ['label'=>'SEO básico',           'price'=>200],
  'design'  => ['label'=>'Diseño personalizado', 'price'=>300],
  'hosting' => ['label'=>'Hosting 1 año',       'price'=>150],
];
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $_SESSION['extras'] = $_POST['extras'] ?? [];
  header('Location:generate_pdf.php');
  exit;
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Extras</title></head><body>
  <h1>Seleccione extras</h1>
  <form method="post">
    <?php foreach($extras as $key=>$opt): ?>
      <label>
        <input type="checkbox" name="extras[]" value="<?= $key ?>">
        <?= $opt['label'] ?> (Q<?= $opt['price'] ?>)
      </label><br>
    <?php endforeach; ?>
    <br><button type="submit">Generar PDF</button>
  </form>
</body></html>
