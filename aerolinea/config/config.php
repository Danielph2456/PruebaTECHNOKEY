<?php
$host = 'localhost';
$dbname = 'technokey';
$user = 'postgres';
$password = '1234567890';

try {
    // Crear una conexión a la base de datos usando PDO
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname;user=$user;password=$password");
    // Establecer el modo de error para lanzar excepciones en lugar de mostrar errores de advertencia
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Capturar cualquier excepción que pueda ocurrir durante la conexión
    echo "Error de conexión: " . $e->getMessage();
}
