<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("head.php"); ?>
</head>
<body class="login">


    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 25rem;">
            <h1 class="text-center" id="lilita-one-regular"> <b>Cap's Shop</b> </h1>
            <hr>
            <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>
            <form action="procesar_login.php" method="POST">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-at"></i></span>
                    <input type="email" class="form-control" id="correo" placeholder="Ingrese su correo" aria-label="Username" aria-describedby="basic-addon1" name="correo">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                    <input type="password" class="form-control" id="password" placeholder="Ingrese su contraseña" name="password" autocomplete="current-password">
                </div>

<?php include 'alerts.php'; ?>

<div class="d-flex gap-2">
    <a href="index.php" class="btn btn-primary"><i class="fa-solid fa-angles-left fa-lg"></i> Volver</a>
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-right-to-bracket fa-lg"></i> Iniciar Sesión</button>
</div>

            </form>
            <div class="mt-3 text-end">
                <!-- <a href="newuser.php" id="link">¿No tienes cuenta? Registrarse</a> -->
            </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>