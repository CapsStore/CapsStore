<?php
session_start();
require_once('conexion.php');

// Recibir datos del formulario
$nombres = $_POST['nombre'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$password = $_POST['password'];

// Encriptar la contraseña en MD5
$password_md5 = md5($password);

try {
    // Verificar si el correo electrónico ya está registrado
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // El correo electrónico ya está registrado
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        // Validar la contraseña encriptada en MD5
        if ($password_md5 == $cliente['password']) {
            // Contraseña válida, procesar el pago y redirigir al cliente a cliente.php
            $_SESSION['cliente'] = $cliente; // Guardar los datos del cliente en la sesión
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta.";
            exit();
        }
    } else {
        // El correo electrónico no está registrado, registrar al cliente con la contraseña encriptada en MD5
        $stmt = $conn->prepare("INSERT INTO clientes (nombres, direccion, telefono, email, password) VALUES (:nombres, :direccion, :telefono, :email, :password)");
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_md5);
        $stmt->execute();

        // Obtener el ID del nuevo cliente
        $cliente_id = $conn->lastInsertId();
        $_SESSION['cliente'] = array(
            'id_cliente' => $cliente_id,
            'nombres' => $nombres,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'email' => $email,
            'password' => $password_md5
        );
    }

    // Procesar el pago y registrar la venta
    $cliente_id = $_SESSION['cliente']['id_cliente'];
    $total_venta = 0;

    // Iniciar transacción
    $conn->beginTransaction();

    foreach ($_SESSION['carrito'] as $item) {
        $id_producto = $item['id'];
        $cantidad = $item['cantidad'];
        $total = $item['precio'] * $cantidad;
        $total_venta += $total;

        // Registrar la venta
        $stmt = $conn->prepare("INSERT INTO ventas (id_cliente, id_producto, cantidad, total) VALUES (:id_cliente, :id_producto, :cantidad, :total)");
        $stmt->bindParam(':id_cliente', $cliente_id);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':total', $total);
        $stmt->execute();

        // Descontar el stock del producto vendido
        $stmt = $conn->prepare("UPDATE productos SET stock = stock - :cantidad WHERE id_producto = :id_producto");
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->execute();
    }

    // Confirmar transacción
    $conn->commit();

    // Limpiar el carrito
    unset($_SESSION['carrito']);

    // Redirigir al cliente a cliente.php
    header("Location: index.php");
    exit();

} catch(PDOException $e) {
    // Revertir transacción en caso de error
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
