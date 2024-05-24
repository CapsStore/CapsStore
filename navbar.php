<nav class="navbar navbar-expand-lg text-white">
  <div class="container-fluid text-white">
    <a class="navbar-brand text-white" href="#"> <b>Cap's Shop</b> </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
      </ul>
      <ul class="navbar-nav me-auto">
      </ul>
      <div class="d-flex m-2">
        <i class="fa-solid fa-cart-shopping fa-lg me-2" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop"></i>
        <a href="login.php" class="fa-solid fa-user-tie fa-lg text-black text-white"></a>
      </div>
    </div>
  </div>
</nav>

<div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-center" id="staticBackdropLabel"> <b> <i class="fa-solid fa-cart-arrow-down fa-lg"></i> Carrito</b> </h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body" id="carritoContenido">
    <div id="listaProductos">
      <?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
        <ul class="list-group">
          <?php foreach ($_SESSION['carrito'] as $item): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <img src="<?php echo "img/articulos/" . $item['imagen']; ?>" alt="Imagen de <?php echo $item['nombre']; ?>" class="img-thumbnail" style="width: 50px;">
                <?php echo $item['nombre']; ?> (x<?php echo $item['cantidad']; ?>)
              </div>
              <div>
                <span><?php echo '$' . number_format($item['precio'] * $item['cantidad'], 0); ?></span>
                <button class="btn btn-danger btn-sm eliminarProducto" data-producto-id="<?php echo $item['id']; ?>">Eliminar</button>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <div class="alert alert-primary text-center" role="alert">No hay productos en el carrito.</div>
      <?php endif; ?>
    </div>
    <hr>
    <div class="d-flex justify-content-between align-items-center">
      <h6>Total:</h6>
      <span id="totalCarrito"> <b> <?php echo '$' . number_format($totalCarrito, 0); ?> </b> </span>
    </div>
    <hr>
    <button class="btn btn-primary btn-block" id="irAPagar" <?php echo empty($_SESSION['carrito']) ? 'disabled' : ''; ?>>Ir a pagar</button>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const irAPagarButton = document.getElementById('irAPagar');

    irAPagarButton.addEventListener('click', function() {
        // Redireccionar a la página "pay.php"
        window.location.href = 'pay.php';
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.eliminarProducto');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const productoId = this.getAttribute('data-producto-id');
            const formData = new FormData();
            formData.append('producto_id', productoId);

            fetch('eliminar_del_carrito.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const carritoContenido = document.getElementById('carritoContenido');
                const listaProductos = document.getElementById('listaProductos');
                const totalCarrito = document.getElementById('totalCarrito');
                listaProductos.innerHTML = '';

                if (Object.keys(data.carrito).length > 0) {
                    const ul = document.createElement('ul');
                    ul.classList.add('list-group');

                    for (const [id, item] of Object.entries(data.carrito)) {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

                        const div = document.createElement('div');
                        const img = document.createElement('img');
                        img.src = `img/articulos/${item.imagen}`;
                        img.alt = `Imagen de ${item.nombre}`;
                        img.classList.add('img-thumbnail');
                        img.style.width = '50px';

                        div.appendChild(img);
                        div.appendChild(document.createTextNode(`${item.nombre} (x${item.cantidad})`));

                        const span = document.createElement('span');
                        span.textContent = `$${(item.precio * item.cantidad).toLocaleString()}`;

                        const button = document.createElement('button');
                        button.classList.add('btn', 'btn-danger', 'btn-sm', 'eliminarProducto');
                        button.textContent = 'Eliminar';
                        button.setAttribute('data-producto-id', item.id);
                        button.addEventListener('click', function() {
                            const productoId = this.getAttribute('data-producto-id');
                            const formData = new FormData();
                            formData.append('producto_id', productoId);

                            fetch('eliminar_del_carrito.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                const carritoContenido = document.getElementById('carritoContenido');
                                const listaProductos = document.getElementById('listaProductos');
                                const totalCarrito = document.getElementById('totalCarrito');
                                listaProductos.innerHTML = '';

                                if (Object.keys(data.carrito).length > 0) {
                                    const ul = document.createElement('ul');
                                    ul.classList.add('list-group');

                                    for (const [id, item] of Object.entries(data.carrito)) {
                                        const li = document.createElement('li');
                                        li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

                                        const div = document.createElement('div');
                                        const img = document.createElement('img');
                                        img.src = `img/articulos/${item.imagen}`;
                                        img.alt = `Imagen de ${item.nombre}`;
                                        img.classList.add('img-thumbnail');
                                        img.style.width = '50px';

                                        div.appendChild(img);
                                        div.appendChild(document.createTextNode(`${item.nombre} (x${item.cantidad})`));

                                        const span = document.createElement('span');
                                        span.textContent = `$${(item.precio * item.cantidad).toLocaleString()}`;

                                        const button = document.createElement('button');
                                        button.classList.add('btn', 'btn-danger', 'btn-sm', 'eliminarProducto');
                                        button.textContent = 'Eliminar';
                                        button.setAttribute('data-producto-id', item.id);

                                        // Add the event listener to the new button
                                        button.addEventListener('click', function() {
                                            const productoId = this.getAttribute('data-producto-id');
                                            const formData = new FormData();
                                            formData.append('producto_id', productoId);

                                            fetch('eliminar_del_carrito.php', {
                                                method: 'POST',
                                                body: formData
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                // Repeat the above steps to update the cart
                                            });
                                        });

                                        li.appendChild(div);
                                        li.appendChild(span);
                                        li.appendChild(button);
                                        ul.appendChild(li);
                                    }

                                    listaProductos.appendChild(ul);
                                } else {
                                    listaProductos.innerHTML = '<p>No hay productos en el carrito.</p>';
                                }

                                totalCarrito.textContent = data.total;
                            });
                        });

                        li.appendChild(div);
                        li.appendChild(span);
                        li.appendChild(button);
                        ul.appendChild(li);
                    }

                    listaProductos.appendChild(ul);
                } else {
                    listaProductos.innerHTML = '<p>No hay productos en el carrito.</p>';
                }

                totalCarrito.textContent = data.total;
            });
        });
    });
});
</script>
