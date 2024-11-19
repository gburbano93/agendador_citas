<?php
session_start();
session_unset();
session_destroy();
echo "Sesión cerrada correctamente."; // Mensaje temporal para pruebas
header("Location: index.php");
exit;
?>