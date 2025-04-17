<?php
// options.php - Paso de selección extendido con UX/UI minimalista
session_start();
if (!isset($_SESSION['site_type'])) {
    header('Location: index.php');
    exit;
}
// Definición de precios y opciones
$options = [
    'pages' => [
        ['id'=>'informativa','label'=>'Página Informativa: 3 páginas (Home, Contacto, Servicios)','price'=>200],
        ['id'=>'ecommerce','label'=>'Página Ecommerce: 7 páginas (Home, Contacto, Tienda, Producto, Categoría, Carrito, Checkout)','price'=>400]
    ],
    'design' => [
        ['id'=>'personalizado','label'=>'Diseño Personalizado','price'=>400],
        ['id'=>'basica','label'=>'Plantilla Básica Incluida','price'=>0]
    ],
    'extras' => [
        ['id'=>'perfil','label'=>'Perfil de Usuario','price'=>200],
        ['id'=>'login','label'=>'Login de Usuario','price'=>150],
        ['id'=>'busqueda','label'=>'Resultado de Búsqueda','price'=>150]
    ],
    'seo' => [
        ['id'=>'basico','label'=>'SEO Básico (Incluido)','price'=>0],
        ['id'=>'intermedio','label'=>'SEO Intermedio','price'=>300],
        ['id'=>'avanzado','label'=>'SEO Avanzado','price'=>950]
    ],
    'branding' => [
        ['id'=>'logo_basico','label'=>'Logotipo Básico: 3 Variaciones, 5 iconos','price'=>350],
        ['id'=>'icono_profesional','label'=>'Icono Profesional: formatos PNG, PDF, PSD, AI, mockups','price'=>2300]
    ],
    'hosting' => [
        ['id'=>'dominio','label'=>'Dominio (.com)','price'=>250],
        ['id'=>'compartido','label'=>'Hosting Compartido (5,000–10,000 visitas)','price'=>250],
        ['id'=>'profesional','label'=>'Hosting Profesional (15,000–25,000 visitas)','price'=>800],
        ['id'=>'avanzado','label'=>'Hosting Avanzado (25,000–50,000 visitas)','price'=>1300]
    ]
];
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $_SESSION['options'] = $_POST;
    header('Location: generate_pdf.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Opciones Adicionales</title>
    <style>
        body { margin:0; font-family:Arial,sans-serif; background:#f9f9f9; color:#333; }
        .container { max-width:700px; margin:40px auto; padding:30px; background:#fff; border-radius:8px; box-shadow:0 2px 12px rgba(0,0,0,0.1); }
        h1 { text-align:center; margin-bottom:30px; font-size:1.6em; }
        .section { margin-bottom:25px; }
        .section h2 { font-size:1.2em; margin-bottom:10px; border-bottom:1px solid #e0e0e0; padding-bottom:5px; }
        ul.options { list-style:none; padding:0; margin:0; }
        ul.options li { display:flex; align-items:center; margin-bottom:12px; }
        input[type=checkbox], input[type=radio] { margin-right:12px; accent-color:#3498DB; }
        .price { font-weight:bold; margin-left:auto; }
        .form-group { display:flex; align-items:center; margin-top:10px; }
        .form-group label { flex:1; }
        .form-group input[type=number] { width:80px; padding:6px; border:1px solid #ccc; border-radius:4px; }
        .btn { display:block; width:100%; padding:12px; background:#3498DB; color:#fff; border:none; border-radius:4px; font-size:1.1em; cursor:pointer; margin-top:20px; }
        .btn:hover { background:#2980b9; }
        .summary { background:#eef9ff; padding:15px; border-left:4px solid #3498DB; border-radius:4px; margin-top:30px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Configura tu Cotización</h1>
    <form method="post">
        <?php foreach (['pages','design','extras','seo','branding','hosting'] as $group): ?>
            <div class="section">
                <h2><?php echo ucwords(($group==='pages'?'Escoge tipo de Página': ($group==='design'?'Tipo de Diseño': ($group==='extras'?'Páginas Adicionales': ($group==='seo'?'SEO': ($group==='branding'?'Branding':'Dominio y Hosting')))))); ?></h2>
                <ul class="options">
                    <?php foreach ($options[$group] as $opt): ?>
                        <li>
                            <input type="checkbox" id="<?php echo $opt['id']; ?>" name="<?php echo $group; ?>[]" value="<?php echo $opt['id']; ?>" <?php echo ($group==='seo' && $opt['id']==='basico')?'checked':''; ?>>
                            <label for="<?php echo $opt['id']; ?>"><?php echo $opt['label']; ?></label>
                            <?php if($opt['price']>0): ?><span class="price">Q<?php echo number_format($opt['price'],2); ?></span><?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if($group==='extras'): ?>
                    <p>Otras páginas avanzadas: Q100 por página.</p>
                    <div class="form-group">
                        <label for="num_extra_pages">¿Cuántas páginas adicionales?</label>
                        <input type="number" id="num_extra_pages" name="extra_pages" min="0" value="0">
                    </div>
                <?php endif; ?>
                <?php if($group==='hosting'): ?>
                    <div class="form-group">
                        <label for="num_products">Productos (50 incluidos, +50 = Q100)</label>
                        <input type="number" id="num_products" name="products" step="50" min="50" value="50">
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn">Obtener mi Cotización</button>
    </form>
    <div class="summary">
        <strong>Recomendación:</strong> Nuestra <em>página Ecommerce</em> + <em>SEO Intermedio</em> es la más popular y aumenta un 30% la conversión. ¡Ideal para impulsar tus ventas!
    </div>
</div>
</body>
</html>
