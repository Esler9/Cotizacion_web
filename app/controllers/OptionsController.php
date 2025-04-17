<?php
namespace App\Controllers;
use App\Models\Quote;

class OptionsController
{
    public function show()
    {
        if (!isset(\$_SESSION['site_type'])) {
            header('Location: /'); exit;
        }
        \$quote = new Quote();
        \$options = \$quote->getOptions();
        if (\$_SERVER['REQUEST_METHOD'] === 'POST') {
            \$_SESSION['options'] = \$_POST;
            header('Location: /generate_pdf'); exit;
        }
        include __DIR__ . '/../Views/options.php';
    }
}