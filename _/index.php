<?php
include_once("conexion.php"); // Incluir el archivo de conexión

// Consulta SQL para obtener los productos
$query = "SELECT * FROM Productos";
$resultado = $conn->query($query);
$productos = $resultado->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los productos como un array asociativo
?>

<html lang="en">
<head>
<?php include_once("head.php"); ?>
</head>
<body>

<?php include_once("navbar.php"); ?>

<!-- Mostramos los productos -->
<div class="container mt-4">
    <div class="row">
        <?php foreach ($productos as $producto): ?>
        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="<?php echo "img/articulos/".$producto['imagen']; ?>" class="card-img-top" alt="Imagen de <?php echo $producto['nombre']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                    <p class="card-text">Precio: <?php echo '$' . number_format($producto['precio'], 2); ?></p>
                    <a href="#" class="btn btn-primary btn-agregar">Agregar al Carrito</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>


<!-- Modal del carrito -->
<div class="modal fade" id="carritoModal" tabindex="-1" aria-labelledby="carritoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="carritoModalLabel">Carrito de Compras</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <ul id="lista-carrito" class="list-group">
              <!-- Los productos agregados se mostrarán aquí -->
            </ul>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-6">
            <p>Total: $<span id="total">0.00</span></p>
          </div>
          <div class="col-md-6 text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Realizar Pedido</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Script JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Script JavaScript -->
<!-- Script JavaScript -->
<!-- Script JavaScript -->
<!-- Script JavaScript -->
<script>
$(document).ready(function(){
    // Objeto para almacenar los productos en el carrito
    var carrito = {};

    // Variables para llevar el conteo de artículos agregados y el total del carrito
    var totalCarrito = 0;
    var numArticulos = 0;

    // Función para agregar un artículo al carrito
    $(".btn-agregar").click(function(){
        // Obtener información del producto
        var idProducto = $(this).closest('.card').data('id');
        var nombreProducto = $(this).closest('.card').find('.card-title').text();
        var precioProducto = parseFloat($(this).closest('.card').find('.card-text').text().replace('Precio: $', ''));
        var imagenProducto = $(this).closest('.card').find('.card-img-top').attr('src');
        
        // Verificar si el producto ya está en el carrito
        if (carrito.hasOwnProperty(idProducto)) {
            // Si ya está, incrementar la cantidad y actualizar el subtotal
            carrito[idProducto].cantidad++;
            carrito[idProducto].subtotal = carrito[idProducto].cantidad * precioProducto;
        } else {
            // Si no está, agregarlo al carrito
            carrito[idProducto] = {
                nombre: nombreProducto,
                precio: precioProducto,
                cantidad: 1,
                subtotal: precioProducto,
                imagen: imagenProducto
            };
        }

        // Actualizar la vista del carrito
        actualizarCarrito();
    });

    // Función para eliminar un producto del carrito
    $("#lista-carrito").on("click", ".eliminar", function(){
        var idProducto = $(this).closest('.list-group-item').data('id');
        var precioProducto = carrito[idProducto].precio;
        var cantidadProducto = carrito[idProducto].cantidad;

        // Restar el precio del producto eliminado del total del carrito
        totalCarrito -= precioProducto * cantidadProducto;
        // Restar la cantidad del producto eliminado del contador de artículos
        numArticulos -= cantidadProducto;

        // Eliminar el producto del carrito
        delete carrito[idProducto];
        // Eliminar el elemento correspondiente del HTML
        $(this).closest('.list-group-item').remove();

        // Actualizar el contador de artículos y el total del carrito
        $("#contador-articulos").text(numArticulos);
        $("#total").text(totalCarrito.toFixed(2));
    });

    // Función para modificar la cantidad de un producto en el carrito
    $("#lista-carrito").on("change", ".cantidad", function(){
        var idProducto = $(this).closest('.list-group-item').data('id');
        var precioProducto = carrito[idProducto].precio;
        var cantidadAnterior = carrito[idProducto].cantidad;
        var nuevaCantidad = parseInt($(this).val());

        // Restar el precio del producto con la cantidad anterior del total del carrito
        totalCarrito -= precioProducto * cantidadAnterior;
        // Sumar el precio del producto con la nueva cantidad al total del carrito
        totalCarrito += precioProducto * nuevaCantidad;

        // Actualizar la cantidad del producto en el carrito y su subtotal
        carrito[idProducto].cantidad = nuevaCantidad;
        carrito[idProducto].subtotal = precioProducto * nuevaCantidad;

        // Actualizar el total del carrito
        $("#total").text(totalCarrito.toFixed(2));
    });

    // Función para actualizar el contenido del carrito
    function actualizarCarrito() {
        // Vaciar la lista del carrito
        $("#lista-carrito").empty();
        // Reiniciar el total del carrito
        totalCarrito = 0;
        // Reiniciar el contador de artículos
        numArticulos = 0;
        // Recorrer el objeto carrito y volver a llenar la lista
        for (var key in carrito) {
            if (carrito.hasOwnProperty(key)) {
                var producto = carrito[key];
                // Agregar el precio del producto al total del carrito
                totalCarrito += producto.subtotal;
                // Agregar la cantidad del producto al contador de artículos
                numArticulos += producto.cantidad;
                // Crear un nuevo elemento en la lista del carrito
                var nuevoItem = '<li class="list-group-item" data-id="' + key + '">' +
                                    '<div class="row align-items-center">' +
                                        '<div class="col-md-2">' +
                                        //     '<img src="' + producto.imagen + '" alt="Imagen de ' + producto.nombre + '" class="img-thumbnail">' +
                                        // '</div>' +
                                        '<div class="col-md-4">' +
                                            '<p>' + producto.nombre + '</p>' +
                                            '<p>Precio: $' + producto.precio.toFixed(2) + '</p>' +
                                        '</div>' +
                                        '<div class="col-md-3">' +
                                            '<input type="number" class="form-control cantidad" value="' + producto.cantidad + '" min="1">' +
                                        '</div>' +
                                        '<div class="col-md-3 text-end">' +
                                            '<button type="button" class="btn btn-danger eliminar">Eliminar</button>' +
                                        '</div>' +
                                    '</div>' +
                                '</li>';
                $("#lista-carrito").append(nuevoItem);
            }
        }
        // Actualizar el contador de artículos y el total del carrito
        $("#contador-articulos").text(numArticulos);
        $("#total").text(totalCarrito.toFixed(2));
    }
});
</script>






</body>
</html>