<?php
session_start();
require_once 'includes/db_connection.php'; // Archivo que contiene la conexión a la base de datos

include 'includes/header.php';


if (isset($_SESSION['user_id']) && (!isset($_GET['page']) && $_GET['page'] !== 'logout')) {
    header("Location: index.php?page=logout");
    exit;
}elseif (isset($_SESSION['user_id']) && (!isset($_GET['page']) && $_GET['page'] !== 'scheduleAppointment')) {
    header("Location: index.php?page=scheduleAppointment");
    exit;
}



// Cargar contenido dinámico de acuerdo a la URL
if (isset($_GET['page']) && file_exists("pages/{$_GET['page']}.php")) {
    include "pages/{$_GET['page']}.php";
} else {
    include 'pages/home.php'; // Página por defecto
}

include 'includes/footer.php';
?>