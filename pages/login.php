<?php


if (isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirige al index si ya está logueado
    exit;
}



// Verifica si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica que ambos campos no estén vacíos
    if (!empty($username) && !empty($password)) {
        // Consulta para obtener el usuario por el nombre de usuario
        $query = "SELECT id, username, password_hash FROM usuarios WHERE username = ?";

        // Preparar y ejecutar la consulta
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            // Verifica si el usuario existe
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $username, $password_hash);
                $stmt->fetch();

                // Verifica la contraseña
                if (password_verify($password, $password_hash)) {
                    // Iniciar sesión
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $username;

                    // Redirige al usuario a la página de inicio
                    header('Location: index.php');
                    exit;
                } else {
                    $error = "Contraseña incorrecta.";
                }
            } else {
                $error = "El usuario no existe.";
            }

            $stmt->close();
        } else {
            $error = "Error en la consulta.";
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Agendamiento de citas</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div>
        <h1><a href="home.php"> Bienvenido al portal de citas </a></h1>
        <?php if (!empty($error)) : ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <hr>
        <form action="./index.php?page=login" method="POST">
            <label for="username">Nombre de usuario</label>
            <input type="text" id="username" name="username" placeholder="Ingresa tu usuario" require/>
            <label for="contraseña">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" require/>
            <button type="submit">Ingresar</button>
            <br>
            <div>
                <h5> <a href="/register.php">Crear cuenta</a></h5>
            </div>
            </p>
        </form>
    </div>
</body>

</html>
