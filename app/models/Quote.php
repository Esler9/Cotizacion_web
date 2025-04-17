<?php
namespace App\Models;

class Quote
{
    public function getOptions()
    {
        return [
            'design' => [
                ['id'=>'basica','label'=>'Plantilla Básica','price'=>0],
                ['id'=>'personalizado','label'=>'Diseño Personalizado','price'=>400],
                ['id'=>'profesional','label'=>'Diseño Pro Mercado','price'=>1500],
            ],
            // ... otras secciones igual que antes ...
        ];
    }

    public function calculate(\$type, array \$selections)
    {
        // lógica para calcular ítems basados en \$type y \$selections
        // devuelve arreglo [ ['desc'=>..., 'price'=>...], ... ]
    }
}