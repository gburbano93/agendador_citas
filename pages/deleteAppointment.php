<?php


if (!isset($_SESSION['user_id'])) {
    header('Location: ./index.php?page=home');
    exit;
}

// Verifica que el parámetro 'id' esté presente en la URL y sea un número
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cita_id = $_GET['id'];

    // Cambiar el estado de la cita en la tabla 'citas_disponibles' a "disponible"
    $sql_update = "UPDATE citas_disponibles SET estado = 'disponible', id_usuario = NULL, id_cita = NULL WHERE id_cita = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $cita_id);
    $stmt_update->execute();


    // Eliminar la cita de la tabla 'citas'
    $sql = "DELETE FROM citas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cita_id);
    $stmt->execute();



    // Redirigir con el mensaje de éxito
    header('Location: ./index.php?page=citas&success=2'); // success=2 para eliminación exitosa
    exit;
} else {
    // Si no se proporciona un id válido, redirige a la lista de citas
    header('Location: ./index.php?page=citas');
    exit;
}
