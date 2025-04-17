<?php
namespace App\models;

class Quote
{
    public function getOptions(): array
    {
        return [
            'design' => [
                ['id'=>'basica','label'=>'Plantilla Básica','price'=>0],
                ['id'=>'personalizado','label'=>'Diseño Personalizado','price'=>400],
                ['id'=>'profesional','label'=>'Diseño Profesional','price'=>1500],
            ],
            'extras' => [
                ['id'=>'perfil','label'=>'Perfil de Usuario','price'=>200],
                ['id'=>'login','label'=>'Login de Usuario','price'=>150],
                ['id'=>'busqueda','label'=>'Resultado de Búsqueda','price'=>150],
            ],
            'products' => [
                ['id'=>'50','label'=>'50 Productos','price'=>0],
                ['id'=>'50-200','label'=>'50–200 Productos','price'=>250],
                ['id'=>'200-500','label'=>'200–500 Productos','price'=>650],
                ['id'=>'500-1000','label'=>'500–1000 Productos','price'=>1450],
            ],
            'seo' => [
                ['id'=>'basico','label'=>'SEO Básico','price'=>0],
                ['id'=>'intermedio','label'=>'SEO Intermedio','price'=>300],
                ['id'=>'avanzado','label'=>'SEO Avanzado','price'=>950],
            ],
            'branding' => [
                ['id'=>'none','label'=>'No necesito','price'=>0],
                ['id'=>'logo_basico','label'=>'Logotipo Básico','price'=>350],
                ['id'=>'icono_profesional','label'=>'Icono Profesional','price'=>2300],
            ],
            'domain' => [
                ['id'=>'none','label'=>'No necesito','price'=>0],
                ['id'=>'dominio','label'=>'Dominio (.com)','price'=>250],
            ],
            'hosting' => [
                ['id'=>'none','label'=>'No necesito','price'=>0],
                ['id'=>'compartido','label'=>'Hosting Compartido','price'=>250],
                ['id'=>'profesional','label'=>'Hosting Profesional','price'=>800],
                ['id'=>'avanzado','label'=>'Hosting Avanzado','price'=>1300],
            ],
        ];
    }

    public function calculate(string $type, array $sel): array
    {
        // Aquí implementa la lógica de totales similar a generate_pdf
        // Devuelve array de ['desc'=>…, 'price'=>…]
        // …
        return [];
    }
}
