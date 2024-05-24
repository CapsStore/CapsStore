<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><b>Zen Shooping</b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
      </ul>
    </div>
    <!-- Icono de carrito con contador -->
    <div class="navbar-nav ml-auto">
      <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#carritoModal">
        <i class="fas fa-shopping-cart"></i> <!-- Icono de carrito de Font Awesome -->
        <span id="contador-articulos" class="badge bg-primary">0</span> <!-- Contador de artículos -->
      </a>
    </div>
  </div>
</nav>
