<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Controllers\SiteTypeController;
use App\Controllers\OptionsController;
use App\Controllers\PdfController;

session_start();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
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
    echo '404 Not Found';
    break;
}