<?php
require 'php/conexion.php';
session_start();

// Obtener productos
$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nombre Tienda</title>
    <link href="https://fonts.cdnfonts.com/css/destroy" rel="stylesheet">
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

    <main class="productos-container">
        <div class="producto-columna">
            <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <a href="producto.php?id=<?= $producto['id'] ?>">
                    <img src="img/productos/<?= htmlspecialchars($producto['imagen']) ?>" 
                         alt="<?= htmlspecialchars($producto['nombre']) ?>"
                         loading="lazy">
                </a>
                <div class="producto-info">
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <p>€<?= number_format($producto['precio'], 2) ?></p>
                </div>
                <button class="btn-carrito" 
                        data-id="<?= $producto['id'] ?>"
                        data-nombre="<?= htmlspecialchars($producto['nombre']) ?>"
                        data-precio="<?= $producto['precio'] ?>">
                    Añadir al carrito
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'carrito.php'; ?>
    <script src="js/app.js"></script>
</body>
</html>

<img src="img/productos/<?= $imagen ?>" 
     class="imagen-principal img-preload"
     loading="eager" 
     onload="this.classList.remove('img-preload')">