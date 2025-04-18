<?php
namespace App\controllers;
use App\models\Quote;

class OptionsController
{
    public function show()
    {
        if (!isset($_SESSION['site_type'])) {
            header('Location: /');
            exit;
        }

        $quote   = new Quote();
        $options = $quote->getOptions();

        if (!defined('Q_PER_EXTRA_PAGE'))   define('Q_PER_EXTRA_PAGE', 100);
        if (!defined('Q_PER_EXTRA_PRODUCTS')) define('Q_PER_EXTRA_PRODUCTS', 100);

        // Sólo redirige cuando viene la sección de diseño (segundo paso)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['design'])) {
            $_SESSION['options'] = $_POST;
            header('Location: /client-info');
            exit;
        }

        include __DIR__ . '/../views/options.php';
    }
}
