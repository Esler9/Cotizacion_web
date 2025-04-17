<?php
namespace App\controllers;

class SiteTypeController
{
    public function show()
    {
        // Al enviarse el formulario, guardamos y redirigimos
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['site_type'])) {
            $_SESSION['site_type'] = $_POST['site_type'];
            header('Location: /options');
            exit;
        }
        // Renderizamos la vista
        include __DIR__ . '/../views/site_type.php';
    }
}
