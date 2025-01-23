<?php
/**
 * Vista para añadir una red social
 */

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<header>
    <h1>Añadir Red Social</h1>
    <h2><?php echo "Bienvenido " . $_SESSION["nombre"] . "!"; ?></h2>
</header>
<nav>
    <ul>
        <li><a href="/edit">Atras</a></li>
        <li><a href="/">Inicio</a></li>
    </ul>
</nav>
<body>
    <form action="" method="post" class="form-new-trabajo">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="url">URL:</label>
        <input type="text" id="url" name="url" required><br>
        <input type="submit" name="anadir_red_social" value="Añadir Red Social">
    </form>
</body>

</html>