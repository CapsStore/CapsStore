<?php 
if (isset($_GET['CamposVacios'])) {
    echo('
<div class="alert alert-warning text-center mb-2" role="alert" id="mensaje">
<strong class="text-center">Todos los campos son obligatorios.</strong>
</div>
');
}
?>

<?php 
if (isset($_GET['CredencialesIncorrectas'])) {
    echo('
<div class="alert alert-danger text-center mb-2" role="alert" id="mensaje">
<strong class="text-center">Correo electrónico o contraseña incorrectos.</strong>
</div>
');
}
?>

<?php 
if (isset($_GET['ErrorInsertarUsuario'])) {
    echo('
<div class="alert alert-danger text-center mb-2" role="alert" id="mensaje">
<strong class="text-center">Hubo un error al insertar el usuario: ' . $e->getMessage() . '</strong>
</div>
');
}
?>

<?php 
if (isset($_GET['PlacaDuplicada'])) {
    echo('
<div class="alert alert-danger text-center mb-2" role="alert" id="mensaje">
<strong class="text-center">Ya existe un vehículo registrado con esa placa.</strong>
</div>
');
}
?>

<?php 
if (isset($_GET['RegistroExitoso'])) {
    echo('
<div class="alert alert-success text-center mb-2" role="alert" id="mensaje">
<strong class="text-center">Usuario registrado exitosamente.</strong>
</div>
');
}
?>

<?php 
if (isset($_GET['AutoRegistradoConExito'])) {
    echo('
<div class="alert alert-success text-center mb-2" role="alert" id="mensaje">
<strong class="text-center">Su vehiculo se ha registrado exitosamente.</strong>
</div>
');
}
?>