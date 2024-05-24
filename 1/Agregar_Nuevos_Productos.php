
<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Productos</title> <!-- Título del Dashboard -->
    <link rel="stylesheet" href="Css/style.css">
<link rel="stylesheet" href="Css/Agregar_Nuevos_Productos.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        <div class="nav container">
            <div class="logo">
            </div>
            <a href="/PRUEBA/index.php" class="logo">Zen Shooping</a>
            <a href="Modificar_Productos.php" class="dashboard">Modificar Productos</a> <!-- Título del Dashboard -->
            <a href="#" class="dashboard">Agregar Productos</a> <!-- Título del Dashboard -->
            <a href="Lista_Ventas.php" class="dashboard">Lista Ventas</a>
             <!-- cart-Icon -->
             <i class='bx bx-shopping-bag' id="cart-icon"></i>
             <!-- cart- -->
             <div class="cart">
                 <h2 class="cart-title"> Tu Carrito</h2>
                 <!-- content- -->
                 <div class="cart-content">
             <!-- Remove cart --> 
             <i class='bx bxs-trash-alt cart-remove' ></i>
          </div>
            <!-- Total- --> 
            <div class="total">
                 <div class="total-title">Total</div>
                 <div class="total-price">$0</div>
         </div>
             <!-- Buy Botton- --> 
             <button type="button" class="btn-buy">Compre Ahora</button>
             <!-- Cart Close- --> 
             <i class='bx bx-x' id="close-cart"></i>
 
     </div>
        </div>
    </header>

    <section class="container">
        <form id="productForm">
            <div class="form-group">
                <label for="productName">Nombre del Producto:</label>
                <input type="text" id="productName" required>
            </div>
            <div class="form-group">
                <label for="productPrice">Precio del Producto:</label>
                <input type="number" id="productPrice" required>
            </div>
            <div class="form-group">
                <label for="productImage">Imagen del Producto:</label>
                <input type="file" id="productImage" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="productStock">Stock del Producto:</label>
                <input type="number" id="productStock" required>
            </div>
            <div class="form-group">
            </div>
            <button type="submit">Agregar Producto</button>
        </form>
        <div id="confirmationMessage" style="display: none;">
            Producto agregado exitosamente.
        </div>
    </section>

    <link rel="stylesheet" href="Agregar_Nuevos_Productos.css">

</body>
</html>
