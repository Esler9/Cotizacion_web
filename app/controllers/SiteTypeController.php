<?php
namespace App\Controllers;

class SiteTypeController
{
    /**
     * Muestra el formulario de selección de tipo de sitio
     */
    public function show()
    {
        // Si viene un POST con site_type, lo guardamos y redirigimos
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            !empty($_POST['site_type'])
        ) {
            $_SESSION['site_type'] = $_POST['site_type'];
            header('Location: /options');
            exit;
        }

        // Incluye la vista
        include __DIR__ . '/../views/site_type.php';
    }
}
