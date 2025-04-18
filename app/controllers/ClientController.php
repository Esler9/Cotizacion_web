<?php
namespace App\controllers;

class ClientController
{
    public function show()
    {
        if (empty($_SESSION['site_type']) || empty($_SESSION['options'])) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Guarda info del cliente
            $_SESSION['client'] = $_POST['client'];
            header('Location: /summary');
            exit;
        }

        include __DIR__ . '/../views/client_info.php';
    }
}
