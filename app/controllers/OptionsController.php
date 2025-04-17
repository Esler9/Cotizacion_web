<?php
namespace App\controllers;

use App\models\Quote;

class OptionsController
{
    public function show()
    {
        // Si no hay tipo de sitio, volvemos al inicio
        if (!isset($_SESSION['site_type'])) {
            header('Location: /');
            exit;
        }

        // Cargamos opciones desde el Model
        $quote   = new Quote();
        $options = $quote->getOptions();

        // Al enviar, guardamos y redirigimos
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['options'] = $_POST;
            header('Location: /generate_pdf');
            exit;
        }

        include __DIR__ . '/../views/options.php';
    }
}
