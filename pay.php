<?php
// Iniciar la sesión
session_start();

// Verificar si el carrito está vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: index.php");
    exit();
}

// Calcular el total del carrito
$totalCarrito = 0;
foreach ($_SESSION['carrito'] as $item) {
    $totalCarrito += $item['precio'] * $item['cantidad'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once("head.php"); ?>
</head>
<body>
    <div class="container mt-4">
        <h2>Resumen de tu compra</h2>
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['carrito'] as $item): ?>
                            <tr>
                                <td><?php echo $item['nombre']; ?></td>
                                <td><?php echo $item['cantidad']; ?></td>
                                <td><?php echo '$' . number_format($item['precio'], 0); ?></td>
                                <td><?php echo '$' . number_format($item['precio'] * $item['cantidad'], 0); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <h4>Total:</h4>
                    <h4><?php echo '$' . number_format($totalCarrito, 0); ?></h4>
                </div>
            </div>
            <div class="col-md-6">
                <h2>Ingresa tus datos</h2>
                <form action="procesar_pago.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" >
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" >
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" >
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" >
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" >
                    </div>
                    <button type="submit" class="btn btn-primary">Pagar</button>
                </form>
            </div>
        </div>
        <a href="index.php" class="btn btn-primary mt-3">Volver</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
