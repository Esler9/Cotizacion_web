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

        // 1) Creamos instancia del Model
        $quote = new Quote();

        // 2) Obtenemos todas las secciones y sus opciones
        //    Esto llena $options con design, extras, products_range, seo, branding, domain, hosting
        $options = $quote->getOptions();

        // 3) Definimos constantes para extras de páginas/productos
        define('Q_PER_EXTRA_PAGE',     100);
        define('Q_PER_EXTRA_PRODUCTS', 100);

        // 4) Si el formulario se envía, guardamos y redirigimos
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['options'] = $_POST;
            header('Location: /generate_pdf');
            exit;
        }

        // 5) Finalmente, incluimos la Vista y le pasamos $options
        include __DIR__ . '/../views/options.php';
    }
}
