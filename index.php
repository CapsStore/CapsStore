<?php
// Iniciar la sesión
session_start();

// Incluye el archivo de conexión a la base de datos
include_once("conexion.php");

// Consulta SQL para obtener los productos en stock
$query = "SELECT * FROM productos WHERE stock > 0";
$resultado = $conn->query($query);
$productos = $resultado->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los productos como un array asociativo

// Manejar el formulario de agregar al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['agregar_al_carrito'])) {
        $producto_id = $_POST['producto_id'];
        
        // Verificar si el campo de cantidad está presente y tiene un valor
        if (isset($_POST['cantidad']) && is_numeric($_POST['cantidad']) && $_POST['cantidad'] > 0) {
            $cantidad = (int)$_POST['cantidad'];
        } else {
            $cantidad = 1; // Valor predeterminado en caso de que la cantidad no esté presente o no sea válida
        }

        // Verificar si el carrito ya tiene productos
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }

        // Agregar el producto al carrito
        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
        } else {
            // Obtener los detalles del producto
            $query = "SELECT * FROM productos WHERE id_producto = :id_producto";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_producto', $producto_id, PDO::PARAM_INT);
            $stmt->execute();
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($producto) {
                $_SESSION['carrito'][$producto_id] = array(
                    'id' => $producto['id_producto'],
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'cantidad' => $cantidad,
                    'imagen' => $producto['imagen']
                );
            }
        }
    } elseif (isset($_POST['eliminar_del_carrito'])) {
        $producto_id = $_POST['producto_id'];
        // Eliminar el producto del carrito
        if (isset($_SESSION['carrito'][$producto_id])) {
            unset($_SESSION['carrito'][$producto_id]);
        }
    }
}

// Calcular el total del carrito
$totalCarrito = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $totalCarrito += $item['precio'] * $item['cantidad'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("head.php"); ?> 
</head>
<body>

<?php include_once("navbar.php"); ?>

<!-- Mostramos los productos Disponibles -->
<div class="container mt-4">
    <div class="row">
        <?php if (empty($productos)): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center" role="alert">
                    No hay productos registrados.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($productos as $producto): ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="<?php echo "img/articulos/".$producto['imagen']; ?>" class="card-img-top" alt="Imagen de <?php echo $producto['nombre']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                        <p class="card-text text-end"><i class="fa-solid fa-hand-holding-dollar fa-lg" style="color: #0033ff;"></i> <b><?php echo '$' . number_format($producto['precio'], 0); ?> </b> </p>
                        <form method="post" action="index.php">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['id_producto']; ?>">
                            <div class="input-group mb-3">
                                <input type="number" name="cantidad" class="form-control" value="1" min="1" max="<?php echo $producto['stock']; ?>" required>
                                <button type="submit" name="agregar_al_carrito" class="btn btn-primary">Agregar al Carrito</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>