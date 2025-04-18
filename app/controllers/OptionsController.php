<?php
namespace App\controllers;
use App\models\Quote;

class OptionsController
{
    public function show()
    {
        // Asegura que exista el tipo de sitio
        if (!isset($_SESSION['site_type'])) {
            header('Location: /');
            exit;
        }

        // 1) Instancia el Model y obtiene las opciones
        $quote   = new Quote();
        $options = $quote->getOptions();

        // 2) Define constantes para páginas/productos extra
        if (!defined('Q_PER_EXTRA_PAGE')) {
            define('Q_PER_EXTRA_PAGE', 100);
        }
        if (!defined('Q_PER_EXTRA_PRODUCTS')) {
            define('Q_PER_EXTRA_PRODUCTS', 100);
        }

        // 3) Procesa POST únicamente cuando viene la selección de 'design'
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['design'])
        ) {
            // Guarda las opciones seleccionadas
            $_SESSION['options'] = $_POST;
            // Redirige a la generación de PDF
            header('Location: /generate_pdf');
            exit;
        }

        // 4) Renderiza la vista de opciones
        include __DIR__ . '/../views/options.php';
    }
}
