<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zen Shop - Shopping</title>
    <link rel="stylesheet" href="Css/style.css">

    <!-- Box icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
     <!-- Header -->
     <header>
        <div class="nav container">
           <a href="/index.php" class="logo">Zen Shooping</a>
            <a href="Modificar_productos.php" class="admin-view">Vista de Administrador</a>

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
     <!-- shop -->
     <section class="Shop container">
        <h2 class="section-title">Productos</h2>

     <!-- content-->
     <div class="Shop-content">
         <!-- Box 1-->
     <div class="product-box">
        <img src="images/productos/Gorra ClásicaHombre.png" alt="" class="product-img"> 
        <h2 class="product-title">Gorra clasica</h2>
        <span class="price">$25.000</span>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
        <!-- Box 2-->
     <div class="product-box">
        <img src="images/productos/Gorra de Beisbol hombre.png" alt=""class="product-img">
        <h2 class="product-title">Gorra Beisbol</h2>
        <span class="price">$80.000</span>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
        <!-- Box 3-->
     <div class="product-box">
        <img src="images/productos/Gorra Corduroy Script Logo.png" alt=""class="product-img">
        <h2 class="product-title">Gorra Corduroy</h2>
        <span class="price">$85.000</span>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
        <!-- Box 4-->
     <div class="product-box">
        <img src="images/productos/Hoodie Clásico  - eleccion de color.png"alt=""class="product-img">
        <h2 class="product-title">Hoodie Clasico</h2>
        <span class="price">$280.000</span>
        <select class="product-size">
         <option value="S">S</option>
         <option value="M">M</option>
         <option value="L">L</option>
         <option value="XL">XL</option>
     </select>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
         <!-- Box 5-->
     <div class="product-box">
        <img src="images/productos/Hoodie Box Fit Freedom - Crema Unico color.png"alt=""class="product-img">
        <h2 class="product-title">Buzo Fredom capucha</h2>
        <span class="price">$320.000</span>
        <select class="product-size">
         <option value="S">S</option>
         <option value="M">M</option>
         <option value="L">L</option>
         <option value="XL">XL</option>
     </select>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
        <!-- Box 6-->
     <div class="product-box">
        <img src="images/productos/Buzo Cuello Tortuga Box Fit Sunday .png"alt=""class="product-img">
        <h2 class="product-title">Buzo Cuello tortuga</h2>
        <span class="price">$380.000</span>
        <select class="product-size">
         <option value="S">S</option>
         <option value="M">M</option>
         <option value="L">L</option>
         <option value="XL">XL</option>
     </select>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
        <!-- Box 7-->
     <div class="product-box">
        <img src="images/productos/Hoodie Box Fit Iliminatad  - Unico color Gris.png"alt=""class="product-img">
        <h2 class="product-title">Hoodie perchada</h2>
        <span class="price">$450.000</span>
        <select class="product-size">
         <option value="S">S</option>
         <option value="M">M</option>
         <option value="L">L</option>
         <option value="XL">XL</option>
     </select>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
        <!-- Box 8-->
     <div class="product-box">
        <img src="images/productos/Gorra The Green Edit.png"alt=""class="product-img">
        <h2 class="product-title">Gorra Hand</h2>
        <span class="price">$80.000</span>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
        <!-- Box 9-->
     <div class="product-box">
        <img src="images/productos/Gorra Cinco Paneles Community .png"alt=""class="product-img">
        <h2 class="product-title">Gorra Cinco Paneles</h2>
        <span class="price">$99.000</span>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
        <!-- Box 10-->
     <div class="product-box">
        <img src="images/productos/Retreat Cropped Hoodie.png"alt=""class="product-img">
        <h2 class="product-title">Cropped</h2>
        <span class="price">$195.000</span>
        <select class="product-size">
         <option value="S">S</option>
         <option value="M">M</option>
         <option value="L">L</option>
         <option value="XL">XL</option>
     </select>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
        <!-- Box 11-->
     <div class="product-box">
        <img src="images/productos/Chaqueta Puffer Retreat.png"alt=""class="product-img">
        <h2 class="product-title">Chaqueta Puffer</h2>
        <span class="price">$395.000</span>
        <select class="product-size">
         <option value="S">S</option>
         <option value="M">M</option>
         <option value="L">L</option>
         <option value="XL">XL</option>
     </select>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
        <!-- Box 12-->
     <div class="product-box">
        <img src="images/productos/Chaqueta Slim En Denim Freedom .png"alt=""class="product-img">
        <h2 class="product-title">Chaqueta Denim</h2>
        <span class="price">$205.000</span>
        <select class="product-size">
         <option value="S">S</option>
         <option value="M">M</option>
         <option value="L">L</option>
         <option value="XL">XL</option>
     </select>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
        <!-- Box 13-->
     <div class="product-box">
        <img src="images/productos/Chaqueta Bomber Antifluido Sunday.png"alt=""class="product-img">
        <h2 class="product-title">Bommer</h2>
        <span class="price">$205.000</span>
        <select class="product-size">
         <option value="S">S</option>
         <option value="M">M</option>
         <option value="L">L</option>
         <option value="XL">XL</option>
     </select>
        <i class='bx bx-shopping-bag add-cart'></i>
        </div>
    </div>
    </section>

    
  
<!-- Link To JS --> 
<script src="/PRUEBA/js/main.js"></script>




</body>
</html>