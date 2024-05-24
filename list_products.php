<?php
require_once 'conexion.php';


// Verifica si el usuario está autenticado y tiene permiso para ver esta página
if (!isset($_SESSION['correo']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'cliente')) {
    header("Location: index.php");
    exit();
}

// Configuración de paginación
$productos_por_pagina = 10;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina_actual > 1) ? ($pagina_actual * $productos_por_pagina) - $productos_por_pagina : 0;

// Filtro de stock
$stock_filter = isset($_GET['stock']) ? $_GET['stock'] : 'todos';

// Obtener el número total de productos con filtro
switch ($stock_filter) {
    case 'en_stock':
        $total_productos_query = $conn->query("SELECT COUNT(*) FROM productos WHERE stock > 0");
        break;
    case 'sin_stock':
        $total_productos_query = $conn->query("SELECT COUNT(*) FROM productos WHERE stock = 0");
        break;
    default:
        $total_productos_query = $conn->query("SELECT COUNT(*) FROM productos");
        break;
}
$total_productos = $total_productos_query->fetchColumn();
$total_paginas = ceil($total_productos / $productos_por_pagina);

// Obtener productos para la página actual con filtro
switch ($stock_filter) {
    case 'en_stock':
        $stmt = $conn->prepare("SELECT * FROM productos WHERE stock > 0 LIMIT :inicio, :productos_por_pagina");
        break;
    case 'sin_stock':
        $stmt = $conn->prepare("SELECT * FROM productos WHERE stock = 0 LIMIT :inicio, :productos_por_pagina");
        break;
    default:
        $stmt = $conn->prepare("SELECT * FROM productos LIMIT :inicio, :productos_por_pagina");
        break;
}

$stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
$stmt->bindValue(':productos_por_pagina', $productos_por_pagina, PDO::PARAM_INT);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<?php include_once("head.php"); ?> 
</head>
<body>

<?php include_once("navbar_conf.php"); ?>

<div class="container-fluid">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-center"><i class="fa-solid fa-boxes-stacked fa-lg"></i> Lista de Productos</h2>
        <a href="agregar_producto.php" class="btn btn-success">Agregar nuevo producto</a>
    </div>

    <!-- Formulario de filtro de stock -->
<form class="mb-4 d-flex" method="GET" action="">
    <div class="form-group w-25 me-3">
        <label for="stockFilter">Mostrar:</label>
        <select class="form-select" name="stock" id="stockFilter">
            <option value="todos" <?php if ($stock_filter == 'todos') echo 'selected'; ?>>Todos los productos</option>
            <option value="en_stock" <?php if ($stock_filter == 'en_stock') echo 'selected'; ?>>Productos en stock</option>
            <option value="sin_stock" <?php if ($stock_filter == 'sin_stock') echo 'selected'; ?>>Productos sin stock</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Aplicar Filtro</button>
</form>


    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center">PRODUCTO</th>
                    <th class="text-center">PRECIO</th>
                    <th class="text-center">IMAGEN</th>
                    <th class="text-center">STOCK</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                        <td class="text-center"><img src="img/articulos/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" style="width: 50px;"></td>
                        <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                        <td class="text-center">
                            <!-- Formulario para editar producto -->
                            <form action="editar_producto.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <nav class="bg-light" aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if ($pagina_actual <= 1) { echo 'disabled'; } ?>">
                <a class="page-link" href="<?php if ($pagina_actual <= 1) { echo '#'; } else { echo "?pagina=" . ($pagina_actual - 1) . '&stock=' . $stock_filter; } ?>">Anterior</a>
            </li>
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="page-item <?php if ($pagina_actual == $i) { echo 'active'; } ?>">
                    <a class="page-link" href="?pagina=<?= $i . '&stock=' . $stock_filter; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php if ($pagina_actual >= $total_paginas) { echo 'disabled'; } ?>">
                <a class="page-link" href="<?php if ($pagina_actual >= $total_paginas) { echo '#'; } else { echo "?pagina=" . ($pagina_actual + 1) . '&stock=' . $stock_filter; } ?>">Siguiente</a>
            </li>
        </ul>
    </nav>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
