<?php

if (!isset($_SESSION['user_id'])) {
    header('Location: ./index.php?page=home'); // Redirige al index si ya está logueado
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_hora = $_POST['fecha_hora'];
    $especialidad = $_POST['especialidad'];

    $sql = "INSERT INTO citas (fecha_hora, especialidad) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $fecha_hora, $especialidad);
    $stmt->execute();

    header('Location: ./index.php?page=newAppointment');
    exit();
}
?>


    <h1>Agregar Nueva Cita</h1>
    <form method="POST">
        <label for="fecha_hora">Fecha y Hora:</label>
        <input type="datetime-local" name="fecha_hora" required><br><br>
        
        <label for="especialidad">Especialidad:</label>
        <input type="text" name="especialidad" required><br><br>
        
        <button type="submit">Guardar Cita</button>
    </form>

    <a href="index.php">Volver a la lista</a>
