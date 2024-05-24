<?php
session_start(); // Iniciar sesión para acceder a $_SESSION

// Incluye el archivo de conexión a la base de datos
include_once("conexion.php");

// Consulta SQL para obtener los productos en stock
$query = "SELECT * FROM Productos WHERE stock > 0";
$resultado = $conn->query($query);
$productos = $resultado->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los productos como un array asociativo

// Verifica si se ha enviado una solicitud para agregar un producto al carrito
if(isset($_POST['agregar_al_carrito'])) {
    // Recupera los datos del formulario
    $producto_id = $_POST['producto_id'];

    // Busca el producto por su ID
    foreach ($productos as $producto) {
        if ($producto['id_producto'] == $producto_id) {
            // Agrega el producto al carrito (usando sesión)
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = array();
            }

            if (isset($_SESSION['carrito'][$producto_id])) {
                $_SESSION['carrito'][$producto_id]['cantidad']++;
            } else {
                $_SESSION['carrito'][$producto_id] = array(
                    'id' => $producto['id'],
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'imagen' => $producto['imagen'],
                    'cantidad' => 1
                );
            }

            // Redirecciona a la misma página
            header('Location: index.php');
            exit();
        }
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

<!-- Listar productos -->
<!-- Mostramos los productos -->
<div class="container mt-4">
    <div class="row">
        <?php foreach ($productos as $producto): ?>
        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="<?php echo "img/articulos/".$producto['imagen']; ?>" class="card-img-top" alt="Imagen de <?php echo $producto['nombre']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                    <p class="card-text text-end"><i class="fa-solid fa-hand-holding-dollar fa-lg" style="color: #0033ff;"></i> <b><?php echo '$' . number_format($producto['precio'], 0); ?> </b> </p>
                    <form method="post" action="index.php">
                        <input type="hidden" name="producto_id" value="<?php echo $producto['id_producto']; ?>">
                        <button type="submit" name="agregar_al_carrito" class="btn btn-primary">Agregar al Carrito</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Actualizar el carrito en la página de carga
    actualizarCarrito();

    // Función para agregar un producto al carrito
    function agregarAlCarrito(productoId) {
        // Hacer una solicitud AJAX para agregar el producto a la sesión
        fetch('agregar_al_carrito.php', {
            method: 'POST',
            body: JSON.stringify({ productoId: productoId })
        })
        .then(response => response.json())
        .then(data => {
            // Actualizar el carrito después de la respuesta del servidor
            actualizarCarrito();
        });
    }

    // Función para actualizar el contenido del offcanvas con los productos del carrito
    function actualizarCarrito() {
        const listaProductos = document.getElementById('listaProductos');
        listaProductos.innerHTML = ''; // Limpiar la lista de productos

        // Obtener los productos del carrito de la sesión
        fetch('obtener_carrito.php')
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                listaProductos.innerHTML = '<p>No hay productos en el carrito</p>';
                document.getElementById('irAPagar').disabled = true; // Deshabilitar el botón "Ir a pagar" si no hay productos
            } else {
                document.getElementById('irAPagar').disabled = false; // Habilitar el botón "Ir a pagar" si hay productos
            }

            let total = 0;

            data.forEach((producto, index) => {
                const divProducto = document.createElement('div');
                divProducto.classList.add('producto');

                const imagenProducto = document.createElement('img');
                imagenProducto.src = 'img/articulos/' + producto.imagen;
                imagenProducto.classList.add('imagen-producto');
                imagenProducto.style.width = '5rem';
                imagenProducto.style.height = '5rem';

                const infoProducto = document.createElement('div');
                infoProducto.classList.add('info-producto');

                const nombreProducto = document.createElement('div');
                nombreProducto.textContent = producto.nombre;
                nombreProducto.classList.add('nombre-producto');

                const valorProducto = document.createElement('div');
                valorProducto.textContent = '$' + (producto.precio * producto.cantidad).toLocaleString('es-ES');
                valorProducto.classList.add('valor-producto');

                // Input para cambiar la cantidad de productos
                const inputCantidad = document.createElement('input');
                inputCantidad.type = 'number';
                inputCantidad.value = producto.cantidad; // Valor por defecto
                inputCantidad.min = 1; // Valor mínimo permitido
                inputCantidad.classList.add('input-cantidad');
                inputCantidad.addEventListener('change', function () {
                    const cantidad = parseInt(this.value);
                    // Actualizar la cantidad en la sesión
                    fetch('actualizar_cantidad.php', {
                        method: 'POST',
                        body: JSON.stringify({ productoId: producto.id, cantidad: cantidad })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar el carrito después de la respuesta del servidor
                        actualizarCarrito();
                    });
                });

                // Botón para eliminar el producto del carrito
                const btnEliminar = document.createElement('button');
                btnEliminar.textContent = 'Eliminar';
                btnEliminar.classList.add('btn', 'btn-danger', 'btn-eliminar');
                btnEliminar.addEventListener('click', function () {
                    // Eliminar el producto de la sesión
                    fetch('eliminar_producto.php', {
                        method: 'POST',
                        body: JSON.stringify({ productoId: producto.id })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar el carrito después de la respuesta del servidor
                        actualizarCarrito();
                    });
                });

                infoProducto.appendChild(nombreProducto);
                infoProducto.appendChild(valorProducto);
                infoProducto.appendChild(inputCantidad);
                infoProducto.appendChild(btnEliminar);

                divProducto.appendChild(imagenProducto);
                divProducto.appendChild(infoProducto);

                listaProductos.appendChild(divProducto);

                total += producto.precio * producto.cantidad;
            });

            // Actualizar el total del carrito
            const totalCarrito = document.getElementById('totalCarrito');
            totalCarrito.textContent = '$' + total.toLocaleString('es-ES');

            if (data.length === 0) {
                totalCarrito.textContent = '$0.00';
            }
        });
    }

    // Obtener todos los botones "Agregar al Carrito"
    const botonesAgregar = document.querySelectorAll('.btn-agregar');

    // Añadir un evento de clic a cada botón
    botonesAgregar.forEach(boton => {
        boton.addEventListener('click', function (event) {
            event.preventDefault();

            const productoId = this.dataset.productoId;
            agregarAlCarrito(productoId);
        });
    });

    // Evento clic para el botón "Ir a pagar"
    document.getElementById('irAPagar').addEventListener('click', function () {
        // Al hacer clic en "Ir a pagar", redirige a la página pay.php
        window.location.href = 'pay.php'; // Redirigir a la página de pago con los datos del carrito
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>