<nav class="navbar navbar-expand-lg">
  <div class="container-fluid text-white">
    <a class="navbar-brand text-white" href="#" id="lilita-one-regular"> <b>Cap's Shop</b> </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'cliente'): ?>
          <!-- Opciones clientes -->
          <li class="nav-item">
            <a class="nav-link text-white" aria-current="page" href="pedidos.php">Mis pedidos <i class="fa-solid fa-tags fa-lg"></i> </a>
          </li>
        <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
          <!-- Opciones usuarios -->
          <li class="nav-item">
            <a class="nav-link text-white" aria-current="page" href="products.php">Productos <i class="fa-solid fa-truck-ramp-box fa-lg"></i></a>
          </li>
        <?php endif; ?>
      </ul>
      <form class="d-flex" role="search">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a href="logout.php" class="nav-link text-white">Salir <i class="fa-solid fa-right-from-bracket fa-lg"></i></a>
          </li>
        </ul>
      </form>
    </div>
  </div>
</nav>