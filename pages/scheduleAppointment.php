<?php

if (!isset($_SESSION['user_id'])) {
    header('Location: ./index.php?page=home'); // Redirige al index si no está logueado
    exit;
}

// Obtener las citas de la base de datos
$sql = "SELECT * FROM citas ORDER BY fecha_hora";
$result = $conn->query($sql);
?>  

<div class="container mt-4">
    <h1>Citas Médicas Agendadas</h1>

    <!-- Mostrar el mensaje de éxito si 'success' es igual a 1 (agendado) o 2 (eliminado) -->
    <?php if (isset($_GET['success'])): ?>
        <?php if ($_GET['success'] == 1): ?>
            <div class="alert alert-success">
                ¡Cita agendada exitosamente!
            </div>
        <?php elseif ($_GET['success'] == 2): ?>
            <div class="alert alert-warning">
                Cita eliminada correctamente y la disponibilidad restaurada.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <a href="./index.php?page=newAppointment" class="btn btn-primary mb-3">Agregar Nueva Cita</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Especialidad</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cita = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($cita['fecha_hora'])); ?></td>
                    <td><?php echo date('H:i', strtotime($cita['fecha_hora'])); ?></td>
                    <td><?php echo htmlspecialchars($cita['especialidad']); ?></td>
                    <td>
                        <!--<a href="editar.php?id=<?php //echo htmlspecialchars($cita['id']); ?>" class="btn btn-sm btn-warning">Editar</a>-->
                        <a href="./index.php?page=deleteAppointment&id=<?php echo htmlspecialchars($cita['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?')">Eliminar</a>                       
                        

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>