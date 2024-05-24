<?php
$host = 'sql200.epizy.com';
$dbname = 'epiz_30541411_capshop';
$username = 'epiz_30541411';
$password = '1ljsGSAWVLuvE';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>