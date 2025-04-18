<?php
namespace App\models;

class Quote
{
    // Precios base según tipo de sitio
    private const BASE_PRICES = [
        'informativa' => 400,
        'ecommerce'   => 800,
        'scalable'    => 3500
    ];

    // Precio por página extra y por bloque de 50 productos
    private const EXTRA_PAGE_PRICE     = 100;
    private const EXTRA_PRODUCTS_BLOCK = 100;

    /**
     * Devuelve las opciones para cada sección del cotizador.
     * @return array
     */
    public function getOptions(): array
    {
        return [
            'design' => [
                ['id' => 'basica',        'label' => 'Plantilla Básica Incluida',          'price' => 0   ],
                ['id' => 'personalizado', 'label' => 'Diseño Personalizado',                'price' => 400 ],
                ['id' => 'profesional',   'label' => 'Diseño Profesional de Mercadeo',      'price' => 1500],
            ],
            'extras' => [
                ['id' => 'perfil',    'label' => 'Perfil de Usuario',         'price' => 200],
                ['id' => 'login',     'label' => 'Login de Usuario',          'price' => 150],
                ['id' => 'busqueda',  'label' => 'Resultado de Búsqueda',     'price' => 150],
            ],
            'products_range' => [
                ['id' => '50',        'label' => '50 Productos Incluidos',    'price' => 0   ],
                ['id' => '50-200',    'label' => '50–200 Productos',         'price' => 250 ],
                ['id' => '200-500',   'label' => '200–500 Productos',        'price' => 650 ],
                ['id' => '500-1000',  'label' => '500–1000 Productos',       'price' => 1450],
            ],
            'seo' => [
                ['id' => 'basico',     'label' => 'SEO Básico (Incluido)',    'price' => 0   ],
                ['id' => 'intermedio', 'label' => 'SEO Intermedio',           'price' => 300 ],
                ['id' => 'avanzado',   'label' => 'SEO Avanzado',             'price' => 950 ],
            ],
            'branding' => [
                ['id' => 'none',             'label' => 'No necesito (ya tengo)',                'price' => 0   ],
                ['id' => 'logo_basico',      'label' => 'Logotipo Básico (3 variaciones, 5 iconos)', 'price' => 350 ],
                ['id' => 'icono_profesional','label' => 'Icono Profesional (AI, PSD, PDF, PNG)',     'price' => 2300],
            ],
            'domain' => [
                ['id' => 'none',    'label' => 'No necesito (ya tengo)', 'price' => 0  ],
                ['id' => 'dominio', 'label' => 'Dominio (.com)',          'price' => 250],
            ],
            'hosting' => [
                ['id' => 'none',         'label' => 'No necesito (ya tengo)',             'price' => 0   ],
                ['id' => 'compartido',   'label' => 'Hosting Compartido (5k–10k visitas)', 'price' => 250 ],
                ['id' => 'profesional',  'label' => 'Hosting Profesional (15k–25k visitas)', 'price' => 800 ],
                ['id' => 'avanzado',     'label' => 'Hosting Avanzado (25k–50k visitas)',  'price' => 1300],
            ],
        ];
    }

    /**
     * Calcula los ítems de la cotización según el tipo de sitio y las selecciones.
     * @param string $type      'informativa'|'ecommerce'|'scalable'
     * @param array  $selections Datos del formulario ($_SESSION['options'])
     * @return array             Lista de ['desc'=>string, 'price'=>float]
     */
    public function calculate(string $type, array $selections): array
    {
        $items = [];
        $total = 0;

        // Precio base
        $labelMap = [
            'informativa' => 'Página Informativa',
            'ecommerce'   => 'Página Ecommerce',
            'scalable'    => 'Sitio Web Escalable'
        ];
        $basePrice = self::BASE_PRICES[$type] ?? 0;
        $items[] = ['desc' => $labelMap[$type] ?? $type, 'price' => $basePrice];
        $total += $basePrice;

        // Otras opciones (radios y checkboxes)
        $options = $this->getOptions();
        foreach ($options as $group => $opts) {
            if (!isset($selections[$group])) {
                continue;
            }
            $selected = $selections[$group];

            if (is_array($selected)) {
                // Checkbox multiple
                foreach ($selected as $val) {
                    foreach ($opts as $opt) {
                        if ($opt['id'] === $val) {
                            $items[] = ['desc' => $opt['label'], 'price' => $opt['price']];
                            $total += $opt['price'];
                            break;
                        }
                    }
                }
            } else {
                // Radio single
                foreach ($opts as $opt) {
                    if ($opt['id'] === $selected) {
                        $items[] = ['desc' => $opt['label'], 'price' => $opt['price']];
                        $total += $opt['price'];
                        break;
                    }
                }
            }
        }

        // Páginas extra
        $extraPages = (int) ($selections['extra_pages'] ?? 0);
        if ($extraPages > 0) {
            $items[] = ['desc' => "Páginas extra ({$extraPages})", 'price' => $extraPages * self::EXTRA_PAGE_PRICE];
            $total += $extraPages * self::EXTRA_PAGE_PRICE;
        }

        // Productos extra (solo ecommerce)
        $extraProd = (int) ($selections['extra_products'] ?? 0);
        if ($extraProd > 0) {
            $blocks = $extraProd / 50;
            $items[] = ['desc' => "Productos extra ({$extraProd})", 'price' => $blocks * self::EXTRA_PRODUCTS_BLOCK];
            $total += $blocks * self::EXTRA_PRODUCTS_BLOCK;
        }

        return $items;
    }
}
