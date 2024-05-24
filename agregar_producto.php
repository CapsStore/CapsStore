<?php
require_once 'conexion.php';
session_start();

// Verifica si el usuario está autenticado y tiene permiso para ver esta página
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['imagen']['name'];
    $stock = $_POST['stock'];

    if (empty($nombre) || empty($precio) || empty($imagen) || empty($stock)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $target_dir = "img/articulos/";
        $target_file = $target_dir . basename($_FILES['imagen']['name']);

        // Mover el archivo cargado a la carpeta de destino
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO productos (nombre, precio, imagen, stock) VALUES (:nombre, :precio, :imagen, :stock)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindParam(':stock', $stock);

            if ($stmt->execute()) {
                $success = "Producto agregado exitosamente.";
            } else {
                $error = "Hubo un error al agregar el producto.";
            }
        } else {
            $error = "Hubo un error al cargar la imagen.";
        }
    }
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
    <form action="agregar_producto.php" method="POST" enctype="multipart/form-data" class="w-50 mx-auto">

    <h2 class="mb-4 text-center">Agregar Nuevo Producto</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Producto</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" id="precio" name="precio">
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock">
        </div>
        <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </form>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputNombre = document.getElementById('nombre');

        inputNombre.addEventListener('input', function() {
            this.value = this.value
                .toLowerCase() // Primero convertir todo a minúsculas
                .split(' ') // Separar por espacios para obtener cada palabra
                .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Capitalizar la primera letra de cada palabra
                .join(' '); // Volver a unir las palabras con espacios
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
