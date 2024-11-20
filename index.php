<?php
session_start();
require_once 'includes/db_connection.php'; // Archivo que contiene la conexión a la base de datos

include 'includes/header.php';

if (isset($_SESSION['user_id'])) {
    // Si la sesión está iniciada, verifica el valor de 'page'
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 'scheduleAppointment'; // Página por defecto cuando la sesión está iniciada
    }

    switch ($page) {
        case 'logout':
            include 'pages/logout.php';
            break;
        case 'newAppointment':
            include 'pages/newAppointment.php';
            break;
        case 'scheduleAppointment':
            include 'pages/scheduleAppointment.php';
            break;
        case 'deleteAppointment':
            include 'pages/deleteAppointment.php';
            break;
        default:
            include 'pages/scheduleAppointment.php'; // Página por defecto cuando no se pasa 'page'
            break;
    }
} else {
    // Si no hay sesión iniciada, solo se permiten 'login', 'register' o 'home' como valores válidos
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 'home'; // Página por defecto cuando no hay sesión
    }

    switch ($page) {
        case 'login':
            include 'pages/login.php';
            break;
        case 'register':
            include 'pages/register.php';
            break;
        case 'home':
            include 'pages/home.php';
            break;
        default:
            // Si no es una de las páginas permitidas, redirige a 'home' o muestra un mensaje de error
            include 'pages/home.php'; // Página por defecto si no se pasa una página válida
            break;
    }
}

include 'includes/footer.php';
