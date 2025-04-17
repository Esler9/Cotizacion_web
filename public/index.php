<?php
// public/index.php

// 1. Depuración PHP: mostrar todos los errores en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Autoload de Composer
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\SiteTypeController;
use App\Controllers\OptionsController;
use App\Controllers\PdfController;

// 3. Inicia sesión para mantener el flujo
session_start();

// 4. Captura la ruta solicitada (sin query string)
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 5. Enrutamiento básico
switch ($path) {
    case '':
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
        echo '404 Página no encontrada';
        break;
}
