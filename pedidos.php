<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: index.php");
    exit();
}

include_once("conexion.php");

// Obtener el ID del cliente logueado
$correo = $_SESSION['correo'];
$stmt = $conn->prepare("SELECT * FROM clientes WHERE email = :email");
$stmt->bindParam(':email', $correo);
$stmt->execute();
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cliente) {
    $id_cliente = $cliente['id_cliente'];

    // Consultar los pedidos realizados por el cliente
    $query = "SELECT v.id_venta, p.nombre AS producto, v.cantidad, v.total, v.fecha 
              FROM ventas v
              INNER JOIN productos p ON v.id_producto = p.id_producto
              WHERE v.id_cliente = :id_cliente";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
    $stmt->execute();
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $pedidos = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once("head.php"); ?>
</head>
<body>

<?php include_once("navbar_conf.php"); ?>

<div class="container mt-4">
    <h2>Mis Pedidos</h2>
    <?php if (empty($pedidos)): ?>
        <div class="alert alert-warning" role="alert">
            No has realizado ningún pedido.
        </div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo $pedido['id_venta']; ?></td>
                        <td><?php echo $pedido['producto']; ?></td>
                        <td><?php echo $pedido['cantidad']; ?></td>
                        <td><?php echo '$' . number_format($pedido['total'], 0); ?></td>
                        <td><?php echo $pedido['fecha']; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#facturaModal" data-venta-id="<?php echo $pedido['id_venta']; ?>" data-producto="<?php echo $pedido['producto']; ?>" data-cantidad="<?php echo $pedido['cantidad']; ?>" data-total="<?php echo $pedido['total']; ?>">
                                Ver factura
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="facturaModal" tabindex="-1" aria-labelledby="facturaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="facturaModalLabel">Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nombre del Comprador:</strong> <?php echo $cliente['nombres']; ?></p>
                <p><strong>Correo:</strong> <?php echo $cliente['email']; ?></p>
                <p><strong>Dirección:</strong> <?php echo $cliente['direccion']; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $cliente['telefono']; ?></p>
                <hr>
                <p><strong>Producto:</strong> <span id="modalProducto"></span></p>
                <p><strong>Cantidad:</strong> <span id="modalCantidad"></span></p>
                <p><strong>Total:</strong> <span id="modalTotal"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // JavaScript para cargar los detalles de la factura en el modal
    var facturaModal = document.getElementById('facturaModal');
    facturaModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var producto = button.getAttribute('data-producto');
        var cantidad = button.getAttribute('data-cantidad');
        var total = button.getAttribute('data-total');

        var modalProducto = facturaModal.querySelector('#modalProducto');
        var modalCantidad = facturaModal.querySelector('#modalCantidad');
        var modalTotal = facturaModal.querySelector('#modalTotal');

        modalProducto.textContent = producto;
        modalCantidad.textContent = cantidad;
        modalTotal.textContent = '$' + new Intl.NumberFormat('es-ES').format(total);
    });
</script>

</body>
</html>
