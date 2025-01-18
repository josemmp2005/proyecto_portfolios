<?php
/**
 * Vista para el formulario de inicio de sesión
 */
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porfolio</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <h1>Inicio de Sesion</h1>
    </header>

    <nav>
        <ul>
            <li><a href="/">Inicio</a></li>
            <li><a href="/register">Registro</a></li>
        </ul>
    </nav>
    <section class="login">
        <form action="/login" method="post">
            <label for="usuario">Usuario:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" name="submit" value="Iniciar Sesión">
        </form>
    </section>
</body>
<footer class="footerLogin">
    <p>José María Mayén Perez</p>
    <p>a23mapejo@gmail.com</p>
    <P>2ºDAW</P>
    <p>IES. Gran Capitan</p>
</footer>
</html>