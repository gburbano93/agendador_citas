<?php
session_start(); // Inicia la sesión al principio del archivo

// Verificar si el usuario no está logueado
if (!isset($_SESSION['user_id'])) {
    // Redirige al usuario al índice o página de login si no está logueado
    header("Location: index.php");
    exit;
}

// El resto del código para la página de agendador
?>

<div>
  <h1>Editor de citas medicas</h1>
  <br>
  <div1>Has iniciado sesión y aqui va el formulario de las citas agendadas</div1>  
</div>