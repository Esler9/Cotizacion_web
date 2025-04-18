<?php
namespace App\controllers;
use App\models\Quote;

class PreviewController
{
    public function show()
    {
        if (empty($_SESSION['site_type']) 
            || empty($_SESSION['options']) 
            || empty($_SESSION['client'])) {
            header('Location: /');
            exit;
        }

        $quote = new Quote();
        $items = $quote->calculate(
            $_SESSION['site_type'],
            $_SESSION['options']
        );

        include __DIR__ . '/../views/pdf.php';
    }
}
