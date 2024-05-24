<?php
require_once 'conexion.php';
session_start();

// Verifica si el usuario está autenticado y tiene permiso para editar productos
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Obtener detalles del producto para editar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    $stmt = $conn->prepare("SELECT * FROM productos WHERE id_producto = :id_producto");
    $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $stmt->execute();
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        header("Location: products.php");
        exit();
    }
} else {
    header("Location: products.php");
    exit();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['precio'], $_POST['stock'])) {
    // Obtener los datos del formulario
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Verificar si se ha cargado una nueva imagen
    $imagen_nombre = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Si se ha cargado una nueva imagen, procede a procesarla
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temporal = $_FILES['imagen']['tmp_name'];
        $imagen_tipo = $_FILES['imagen']['type'];
        $imagen_tamaño = $_FILES['imagen']['size'];

        // Verificar el tipo de archivo (puedes agregar más tipos si lo necesitas)
        if ($imagen_tipo === 'image/jpeg' || $imagen_tipo === 'image/png') {
            // Mover el archivo a la ubicación deseada
            $ruta_destino = 'img/articulos/' . $imagen_nombre;
            if (move_uploaded_file($imagen_temporal, $ruta_destino)) {
                // La imagen se cargó correctamente
                $imagen = $ruta_destino;
            } else {
                // Error al mover el archivo
                echo "Error al mover el archivo.";
                exit();
            }
        } else {
            // Tipo de archivo no permitido
            echo "Tipo de archivo no permitido. Sube una imagen JPEG o PNG.";
            exit();
        }
    } else {
        // Si no se ha cargado una nueva imagen, mantener la imagen actual
        $imagen_nombre = $producto['imagen'];
    }

    // Actualizar los datos del producto en la base de datos
    $stmt = $conn->prepare("UPDATE productos SET nombre = :nombre, precio = :precio, stock = :stock, imagen = :imagen_nombre WHERE id_producto = :id_producto");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':imagen_nombre', $imagen_nombre);
    $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<?php include_once("head.php"); ?>
</head>
<body>

<?php include_once("navbar_conf.php"); ?>

<div class="container mt-5">
    <form action="editar_producto.php" method="POST" enctype="multipart/form-data" class="w-50 mx-auto">
        <h2 class="mb-4">Editar Producto</h2>
        <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($producto['id_producto']); ?>">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Producto</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="text" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
