<?php
// public/index.php

// DEBUG: mostrar todos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carga Composer
require __DIR__ . '/../vendor/autoload.php';

use App\controllers\SiteTypeController;
use App\controllers\OptionsController;
use App\controllers\PdfController;

session_start();

// 1) Detectar la ruta completa y el prefijo de subcarpeta
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// Ajusta este valor si tu cotizador está en subcarpeta distinta:
$basePath = '/cotizador'; 

// 2) Remover el prefijo '/cotizador' si existe
if (strpos($requestUri, $basePath) === 0) {
    $path = substr($requestUri, strlen($basePath));
} else {
    $path = $requestUri;
}
// Asegurarnos de que empiece con '/', y no con cadena vacía
if ($path === false || $path === '') {
    $path = '/';
}

// 3) Enrutamiento
switch ($path) {
    case '/':
    case '/index.php':
        (new SiteTypeController())->show();
        break;

    case '/options':
        (new OptionsController())->show();
        break;

    case '/generate_pdf':
        (new PdfController())->generate();
        break;

    default:
        header('HTTP/1.0 404 Not Found');
        echo '<h1>404 - Página no encontrada</h1>';
        break;
}
