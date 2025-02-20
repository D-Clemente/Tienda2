<?php
session_start();
require 'conexion.php';

if(!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

// Obtener datos del usuario
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch();

// Obtener pedidos
$pedidos = $pdo->prepare("SELECT * FROM pedidos WHERE usuario_id = ?");
$pedidos->execute([$_SESSION['usuario_id']]);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mi Cuenta</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <section class="cuenta">
        <h2>Bienvenido, <?= htmlspecialchars($usuario['nombre']) ?></h2>
        
        <div class="historial-pedidos">
            <h3>Tus Pedidos</h3>
            <?php while($pedido = $pedidos->fetch()): ?>
            <div class="pedido">
                <p>Pedido #<?= $pedido['id'] ?></p>
                <p>Total: €<?= number_format($pedido['total'], 2) ?></p>
                <p>Fecha: <?= $pedido['fecha'] ?></p>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
</body>
</html>