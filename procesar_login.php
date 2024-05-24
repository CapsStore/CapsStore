<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    if (empty($correo) || empty($password)) {
        header("Location: login.php?CamposVacios");
        exit();
    }

    // Encriptar la contraseña
    $encrypted_password = md5($password);

    // Verificar en la tabla 'clientes'
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE email = :correo AND password = :password");
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':password', $encrypted_password);
    $stmt->execute();

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        session_start();
        $_SESSION['correo'] = $cliente['email'];
        $_SESSION['rol'] = 'cliente';
        header("Location: cliente.php");
        exit();
    }

    // Verificar en la tabla 'usuarios'
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :correo AND password = :password");
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':password', $encrypted_password);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        session_start();
        $_SESSION['correo'] = $usuario['email'];
        $_SESSION['rol'] = 'admin';
        header("Location: admin.php");
        exit();
    }

    // Si no se encuentra en ninguna tabla
    header("Location: login.php?CredencialesIncorrectas");
    exit();
}
?>
