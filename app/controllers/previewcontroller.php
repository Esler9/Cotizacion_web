<?php
// app/controllers/PreviewController.php
namespace App\controllers;

use App\models\Quote;

class PreviewController
{
    /**
     * Paso 4: Muestra el resumen antes de generar el PDF.
     */
    public function show()
    {
        // Validar flujo completo
        if (empty($_SESSION['site_type'])
            || empty($_SESSION['options'])
            || empty($_SESSION['client'])
        ) {
            header('Location: /');
            exit;
        }

        // Calcular la cotización
        $quote = new Quote();
        $items = $quote->calculate(
            $_SESSION['site_type'],
            $_SESSION['options']
        );

        // Carga la vista
        include __DIR__ . '/../views/pdf.php';
    }
}
