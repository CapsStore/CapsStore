<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];

    // Eliminar el producto del carrito
    if (isset($_SESSION['carrito'][$producto_id])) {
        unset($_SESSION['carrito'][$producto_id]);
    }

    // Calcular el total del carrito
    $totalCarrito = 0;
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $item) {
            $totalCarrito += $item['precio'] * $item['cantidad'];
        }
    }

    // Devolver el contenido actualizado del carrito
    $response = [
        'total' => '$' . number_format($totalCarrito, 0),
        'carrito' => $_SESSION['carrito']
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
