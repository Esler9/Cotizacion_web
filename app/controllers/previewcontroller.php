<?php
namespace App\controllers;

use App\models\Quote;

class PreviewController
{
    /**
     * Muestra el paso 3: resumen de la cotización.
     */
    public function show()
    {
        // Validar flujo
        if (empty($_SESSION['site_type']) || empty($_SESSION['options'])) {
            header('Location: /');
            exit;
        }

        // Obtener items
        $quote = new Quote();
        $items = $quote->calculate(
            $_SESSION['site_type'],
            $_SESSION['options']
        );

        // Renderizar la vista de resumen (app/views/pdf.php)
        include __DIR__ . '/../views/pdf.php';
    }
}
