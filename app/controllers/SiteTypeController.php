<?php
namespace App\Controllers;
class SiteTypeController
{
    public function show()
    {
        if (
            \$_SERVER['REQUEST_METHOD'] === 'POST' &&
            !empty(\$_POST['site_type'])
        ) {
            \$_SESSION['site_type'] = \$_POST['site_type'];
            header('Location: /options');
            exit;
        }
        include __DIR__ . '/../Views/site_type.php';
    }
}