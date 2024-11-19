
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <title>Mi sitio web</title>
</head>

<body>
<header>
    <nav>
        <a href="./index.php?page=home">Inicio</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="./index.php?page=logout">Cerrar sesión</a>
        <?php else: ?>
            <a href="./index.php?page=login">Ingresar</a>
            <a href="./index.php?page=register">Registrarse</a>
        <?php endif; ?>
    </nav>
</header>