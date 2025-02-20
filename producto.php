<?php
require 'php/conexion.php';

if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$producto_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$producto_id]);
$producto = $stmt->fetch();

if(!$producto) {
    header('Location: index.php');
    exit;
}

// Obtener imágenes adicionales
$imagenes = json_decode($producto['imagenes_extra']) ?: [];
array_unshift($imagenes, $producto['imagen']);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($producto['nombre']) ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="header">
        <a href="index.php" class="logo">NOMBRE<br>TIENDA</a>
        <nav class="menu">
            <?php if(isset($_SESSION['usuario_id'])): ?>
                <a href="php/cuenta.php" class="menu-item">Cuenta</a>
            <?php else: ?>
                <a href="login.php" class="menu-item">Login</a>
            <?php endif; ?>
            <div class="menu-item">Soporte</div>
            <div class="menu-item" id="carrito-btn">
                Carrito <span class="carrito-contador"><?= count($_SESSION['carrito'] ?? []) ?></span>
            </div>
        </nav>
    </header>

    <main class="producto-detalle">
        <div class="galeria">
            <img src="img/productos/<?= $imagenes[0] ?>" 
                 alt="<?= htmlspecialchars($producto['nombre']) ?>" 
                 class="imagen-principal" 
                 id="imagenPrincipal">
            
            <div class="miniaturas">
                <?php foreach($imagenes as $index => $imagen): ?>
                <img src="img/productos/<?= $imagen ?>" 
                     alt="Miniatura <?= $index + 1 ?>"
                     class="miniatura"
                     onclick="cambiarImagen('<?= $imagen ?>')">
                <?php endforeach; ?>
            </div>
        </div>

        <div class="info-producto">
            <h1><?= htmlspecialchars($producto['nombre']) ?></h1>
            <p class="precio">€<?= number_format($producto['precio'], 2) ?></p>
            
            <div class="descripcion">
                <?= nl2br(htmlspecialchars($producto['descripcion'])) ?>
            </div>

            <button class="btn-carrito" 
                    data-id="<?= $producto['id'] ?>"
                    data-nombre="<?= htmlspecialchars($producto['nombre']) ?>"
                    data-precio="<?= $producto['precio'] ?>">
                Añadir al carrito
            </button>
        </div>
    </main>

    <script>
        function cambiarImagen(nuevaImagen) {
            const imagenPrincipal = document.getElementById('imagenPrincipal');
            imagenPrincipal.style.opacity = 0;
            
            setTimeout(() => {
                imagenPrincipal.src = `img/productos/${nuevaImagen}`;
                imagenPrincipal.style.opacity = 1;
            }, 300);
        }
    </script>
</body>
</html>