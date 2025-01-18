<?php
/**
 * Vista para el registro de usuarios
 */
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porfolio</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <h1>Registro</h1>
    </header>

    <nav>
        <ul>
            <li><a href="/">Inicio</a></li>
            <li><a href="/login">Iniciar sesión</a></li>
        </ul>
    </nav>
    <section class="registro">
        <form action="" method="post" class="">
            Usuario:<input type="text" id="nombre" name="nombre" required>
            Apellidos:<input type="text" id="apellidos" name="apellidos">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <label for="categoria_profesional">Categoría Profesional:</label>
            <select name="categoria_profesional" id="categoria_profesional">
                <option value="Desarrollador">Desarrollador</option>
                <option value="Diseñador">Diseñador</option>
                <option value="Tester">Tester</option>
                <option value="Analista">Analista</option>
            </select>
            <label for="resumen_perfil">Resumen Perfil:</label>
            <textarea name="resumen_perfil" id="resumen_perfil" cols="20" rows="1"></textarea>
            <input type="submit" name="submit" value="registrar">
        </form>
    </section>
    <footer>
        <p>José María Mayén Perez</p>
        <p>a23mapejo@gmail.com</p>
        <P>2ºDAW</P>
        <p>IES. Gran Capitan</p>
    </footer>
</body>

</html>