<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <link rel="stylesheet" href="Css/style.css"> <!-- Ruta relativa desde PRUEBA hacia Css/style.css -->
    <link rel="stylesheet" href="Css/Lista_Ventas.css"> <!-- Ruta relativa desde PRUEBA hacia Css/Lista_Ventas.css -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        function generarReporte() {
            var fechaInicio = document.getElementById("fecha-inicio").value;
            var fechaFin = document.getElementById("fecha-fin").value;

            // Aquí podrías agregar validaciones de las fechas si es necesario

            // Redirigir a una nueva página con los parámetros de las fechas
            window.location.href = "generar_reporte.php?fechaInicio=" + fechaInicio + "&fechaFin=" + fechaFin;
        }
    </script>
</head>
<body>
    <header>
        <div class="nav container">
            <div class="logo">
            </div>
            <a href="/PRUEBA/index.php" class="logo">Zen Shooping</a>
            <a href="Modificar_Productos.php" class="dashboard">Modificar Productos</a><!-- Título del Dashboard -->
            <a href="Agregar_Nuevos_productos.php" class="dashboard">Agregar Productos</a>
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
    <main>
        <h1>Reporte de Ventas</h1>
        <form>
            <label for="fecha-inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha-inicio" name="fecha-inicio">
            <label for="fecha-fin">Fecha de Fin:</label>
            <input type="date" id="fecha-fin" name="fecha-fin">
            <button type="button" onclick="generarReporte()">Generar Reporte</button>
        </form>
    </main>
    <link rel="stylesheet" href="Lista_Ventas.css">

</body>
</html>
