<?php
require 'db_connection.php'; // Incluye la conexión a la base de datos

if (isset($_GET['especialidad'])) {
    $especialidad = $_GET['especialidad'];

    // Obtener las fechas y horas disponibles para la especialidad seleccionada
    $query = "SELECT fecha_hora FROM citas_disponibles WHERE especialidad = ? AND estado = 'disponible'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $especialidad);
    $stmt->execute();
    $result = $stmt->get_result();

    // Almacenar los resultados en un array
    $availableDates = [];
    while ($row = $result->fetch_assoc()) {
        $availableDates[] = $row;
    }

    // Devolver las fechas y horas como JSON
    echo json_encode($availableDates);
}
?>