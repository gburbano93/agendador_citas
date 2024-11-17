<?php
// Configuración de la base de datos
$host = 'localhost';       // Dirección del servidor
$db = 'agendador_bd';  // Nombre de la base de datos
$user = 'root';          // Usuario de la base de datos
$pass = '';       // Contraseña del usuario

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db);

// Verifica si hay errores en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>