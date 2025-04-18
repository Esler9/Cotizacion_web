<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paso 3: Información de Cliente</title>
  <link rel="stylesheet" href="/assets/css/general.css?v=1.0">
  <link rel="stylesheet" href="/assets/css/index.css?v=1.0">
  <link rel="stylesheet" href="/assets/css/options.css?v=1.0">
  <link rel="stylesheet" href="/assets/css/client_info.css?v=1.0">
</head>
<body>
  <div class="container">
    <h1>Paso 3: Información del Cliente</h1>
    <div class="step-indicator">
      <div class="step">1. Tipo de Sitio</div>
      <div class="step">2. Detalles</div>
      <div class="step active">3. Información del Cliente</div>
      <div class="step">4. Resultado</div>
    </div>
    <form method="post" action="/client-info">
      <div class="form-group">
        <label for="client_name">Nombre Completo</label>
        <input type="text" id="client_name" name="client[name]" required placeholder="Tu nombre">
      </div>
      <div class="form-group">
        <label for="client_email">Correo Electrónico</label>
        <input type="email" id="client_email" name="client[email]" required placeholder="tu@correo.com">
      </div>
      <div class="form-group">
        <label for="client_phone">Teléfono de Contacto</label>
        <input type="tel" id="client_phone" name="client[phone]" placeholder="1234-5678">
      </div>
      <div class="nav-buttons">
        <a href="/options" class="btn btn-secondary">Anterior</a>
        <button type="submit" class="btn">Siguiente</button>
      </div>
    </form>
  </div>
</body>
</html>
