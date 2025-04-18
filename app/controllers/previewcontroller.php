<?php
// app/controllers/PreviewController.php
namespace App\controllers;

use App\models\Quote;

class PreviewController
{
    /**
     * Muestra el paso 3 con el resumen de la cotización antes de generar el PDF.
     */
    public function show()
    {
        // Asegura que el usuario haya completado pasos previos
        if (empty($_SESSION['site_type']) || empty($_SESSION['options'])) {
            header('Location: /');
            exit;
        }

        // Calcula los ítems de la cotización
        $quote = new Quote();
        $items = $quote->calculate(
            $_SESSION['site_type'],
            $_SESSION['options']
        );

        // Renderiza la vista de resumen (app/views/pdf.php)
        include __DIR__ . '/../views/pdf.php';
    }
}
