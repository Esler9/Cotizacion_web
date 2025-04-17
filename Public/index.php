<?php
// Depuración rápida
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload
require __DIR__ . '/../vendor/autoload.php';

// Autoload de Composer
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\SiteTypeController;
use App\Controllers\OptionsController;
use App\Controllers\PdfController;

// 2. Inicia sesión
session_start();

// 3. Detecta la ruta (sin query string)
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 4. Enrutamiento básico
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
