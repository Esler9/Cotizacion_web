<?php
// public/index.php

// 1. Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Autoload de Composer
require __DIR__ . '/../vendor/autoload.php';

use App\controllers\SiteTypeController;
use App\controllers\OptionsController;
use App\controllers\PdfController;

// 3. Iniciar sesión
session_start();

// 4. Detectar basePath dinámicamente (subdominio o subcarpeta)
$scriptName = $_SERVER['SCRIPT_NAME'];          // Ej: '/index.php' o '/cotizador/public/index.php'
$basePath   = rtrim(dirname($scriptName), '/'); // Ej: '' en subdominio, '/cotizador/public' en subcarpeta
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 5. Quitar el basePath de la URI para obtener la ruta interna
if ($basePath !== '' && strpos($requestUri, $basePath) === 0) {
    $path = substr($requestUri, strlen($basePath));
} else {
    $path = $requestUri;
}
$path = $path === '' ? '/' : $path;

// 6. Enrutamiento
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
        echo '<h1>404 — Página no encontrada</h1>';
        break;
}
