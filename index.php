<?php
//include 'includes/header.php';
// Cargar contenido dinámico de acuerdo a la URL
if (isset($_GET['page']) && file_exists("pages/{$_GET['page']}.php")) {
    include "pages/{$_GET['page']}.php";
} else {
    include 'pages/login.php'; // Página por defecto
}
//include 'includes/footer.php';
?>