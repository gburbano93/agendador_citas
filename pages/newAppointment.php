<?php

if (!isset($_SESSION['user_id'])) {
    header('Location: ./index.php?page=home'); // Redirige al index si no está logueado
    exit;
}


// Obtener especialidades disponibles
$query = "SELECT DISTINCT especialidad FROM citas_disponibles WHERE estado = 'disponible'";
$result = $conn->query($query);

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // Obtén el ID del usuario logueado
    $fecha_hora = $_POST['fecha_hora'];
    $especialidad = $_POST['especialidad'];

    // Insertar la cita en la tabla 'citas'
    $sql = "INSERT INTO citas (id_usuario, fecha_hora, especialidad) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $fecha_hora, $especialidad);
    if ($stmt->execute()) {
        // Obtener el ID de la cita recién insertada
        $id_cita = $stmt->insert_id;

        // Actualizar la tabla 'citas_disponibles' para marcar la cita como no disponible
        $updateQuery = "UPDATE citas_disponibles SET estado = 'agendada', id_usuario = ?, id_cita = ? WHERE fecha_hora = ? AND especialidad = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("iiss", $user_id, $id_cita, $fecha_hora, $especialidad);
        
        if ($updateStmt->execute()) {
            // Redirige tras guardar exitosamente
            header('Location: ./index.php?page=scheduleAppointment&success=1');
            exit();
        } else {
            $error = "Error al actualizar la disponibilidad de la cita: " . $updateStmt->error;
        }
    } else {
        $error = "Error al guardar la cita: " . $stmt->error;
    }
}
?>

<!-- Incluye Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="d-flex flex-column align-items-center mt-4">
    <h1 class="mb-4 text-center">Agregar Nueva Cita</h1>

    <!-- Mensaje de error o éxito -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif (isset($_GET['success'])): ?>
        <div class="alert alert-success">¡Cita guardada exitosamente!</div>
    <?php endif; ?>

    <form method="POST" class="needs-validation w-150" novalidate>
        <div class="mb-3">
            <label for="especialidad" class="form-label">Especialidad:</label>
            <select id="especialidad" name="especialidad" class="form-control" required onchange="loadAvailableDates()">
                <option value="">Selecciona una especialidad</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?php echo $row['especialidad']; ?>"><?php echo htmlspecialchars($row['especialidad']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="mb-3" id="dates-container" style="display: none;">
            <label for="fecha_hora" class="form-label">Fecha y Hora:</label>
            <select id="fecha_hora" name="fecha_hora" class="form-control" required>
                <option value="">Selecciona una fecha y hora</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">Guardar Cita</button>
        <a href="index.php" class="btn btn-secondary mt-2">Volver a la lista</a>
    </form>
</div>

<script>
function loadAvailableDates() {
    const especialidad = document.getElementById('especialidad').value;
    const dateContainer = document.getElementById('dates-container');
    const dateSelect = document.getElementById('fecha_hora');
    
    // Limpiar las opciones actuales
    dateSelect.innerHTML = '<option value="">Selecciona una fecha y hora</option>';

    if (especialidad === "") {
        dateContainer.style.display = "none";
        return;
    }

    // Realizar una solicitud AJAX para obtener las fechas y horas disponibles para la especialidad seleccionada
    const xhr = new XMLHttpRequest();
    xhr.open('GET', './includes/getAvailableDates.php?especialidad=' + especialidad, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const availableDates = JSON.parse(xhr.responseText);
            if (availableDates.length > 0) {
                dateContainer.style.display = "block";
                availableDates.forEach(function(date) {
                    const option = document.createElement('option');
                    option.value = date.fecha_hora;
                    option.textContent = date.fecha_hora;
                    dateSelect.appendChild(option);
                });
            } else {
                dateContainer.style.display = "none";
                alert('No hay citas disponibles para esta especialidad.');
            }
        }
    };
    xhr.send();
}
</script>