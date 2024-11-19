<?php
if (isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirige al index si ya está logueado
    exit;
}


// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validar que los campos no estén vacíos
    if (empty($username) || empty($email) || empty($password)) {
        echo "Todos los campos son obligatorios.";
    } else {
        // Verificar si el usuario ya existe en la base de datos (por email)
        $sql_check_email = "SELECT * FROM usuarios WHERE email = '$email'";
        $result = mysqli_query($conn, $sql_check_email);
        if (mysqli_num_rows($result) > 0) {
            echo "El correo electrónico ya está registrado.";
        } else {
            // Cifrar la contraseña antes de guardarla (usando bcrypt)
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            // Insertar los datos del usuario en la base de datos
            $sql = "INSERT INTO usuarios (username, password_hash, email) VALUES ('$username', '$passwordHash', '$email')";

            if (mysqli_query($conn, $sql)) {
                echo "Usuario registrado exitosamente.";
                // Redirigir a otra página después del registro exitoso, por ejemplo, a la página de login
                header("Location: ./index.php?page=login");
                exit();
            } else {
                echo "Error al registrar usuario: " . mysqli_error($conn);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/registro.css">
    
    <title>Registro</title>
</head>

<body>
    <div>
    <h1> 
        <a href="./index.php">Agendamiento de citas</a>
    </h1>

    <p>
        Bienvenido al portal de registro, a continuación por favor ingrese sus datos para continuar con el registro. 
    </p>
    
    <section>
        <!-- El formulario ya se encuentra aquí para que se envíe de nuevo si hay un error -->
        <form action="./index.php?page=register" method="POST">
            <input type="text" name="username" placeholder="Nombre de usuario" required><br><br>
            <input type="email" name="email" placeholder="Correo electrónico" required><br><br>
            <input type="password" name="password" placeholder="Ingrese una contraseña" required><br><br>
            <input type="submit" value="Registrar">
        </form>
    </section>
    </div>    
</body>
</html>