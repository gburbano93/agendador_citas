<?php

if (!isset($_SESSION['user_id'])) {
    header('Location: ./index.php?page=home'); // Redirige al index si ya está logueado
    exit;
}

// Obtener las citas de la base de datos
$sql = "SELECT * FROM citas ORDER BY fecha_hora";
$result = $conn->query($sql);
?>
    <h1>Citas Médicas Agendadas</h1>
    <a href="./index.php?page=newAppointment">Agregar Nueva Cita</a>

    <table border="1">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Especialidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cita = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($cita['fecha_hora'])); ?></td>
                    <td><?php echo date('H:i', strtotime($cita['fecha_hora'])); ?></td>
                    <td><?php echo htmlspecialchars($cita['especialidad']); ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $cita['id']; ?>">Editar</a>
                        <a href="eliminar.php?id=<?php echo $cita['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

