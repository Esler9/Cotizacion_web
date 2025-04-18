<?php
// public/index.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use App\controllers\SiteTypeController;
use App\controllers\OptionsController;
use App\controllers\ClientController;
use App\controllers\PreviewController;
use App\controllers\PdfController;

session_start();

// Detecta el basePath dinámico
$script   = $_SERVER['SCRIPT_NAME'];
$basePath = rtrim(dirname($script), '/');
$uri      = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path     = ($basePath && strpos($uri, $basePath) === 0)
            ? substr($uri, strlen($basePath))
            : $uri;
$path     = $path ?: '/';

switch ($path) {
    case '/':
    case '/index.php':
        (new SiteTypeController())->show();
        break;

    case '/options':
        (new OptionsController())->show();
        break;

    case '/client-info':
        (new ClientController())->show();
        break;

    case '/summary':
        (new PreviewController())->show();
        break;

    case '/generate_pdf':
        (new PdfController())->generate();
        break;

    default:
        header('HTTP/1.0 404 Not Found');
        echo '<h1>404 — Página no encontrada</h1>';
        break;
}
